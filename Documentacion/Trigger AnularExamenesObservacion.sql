 

CREATE DEFINER = CURRENT_USER TRIGGER `sidiraunt`.`anularExamenesDeObservacion` AFTER UPDATE ON `observacion` FOR EACH ROW
BEGIN
	DECLARE codExamenPostulanteAnulado int;
	DECLARE var_final INTEGER DEFAULT 0;
	
	DECLARE codGrupo INT;
	DECLARE codObservacion INT;
    -- EL TRIGGER SE ACTIVA CUANDO SE HACE UN UPDATE EN LA TABLA observacion y el cambio es de codEstado = 3
   
	-- consulta select que retorna la lista de examen_postulante que están involucrados en cierta observacion de tipo grupo_patron
	declare cursor_examenPostulante_grupopatron CURSOR FOR (
				select GP.codGrupoPatron, EP.codExamenPostulante, O.codObservacion from grupo_patron GP
					inner join examen_postulante EP on 
						GP.vectorExamenPostulante like concat('%',EP.codExamenPostulante,',%')
					or 	GP.vectorExamenPostulante like concat('%,',EP.codExamenPostulante,'%')
					INNER join observacion O on O.codObservacion = GP.codObservacion
					where O.codObservacion = NEW.codObservacion
				);

	-- consulta select que retorna la lista de examen_postulante que están involucrados en cierta observacion de tipo GrupoIguales
	declare cursor_examenPostulante_grupoiguales CURSOR FOR (
		select GI.codGrupo, EP.codExamenPostulante, O.codObservacion from grupo_iguales GI
			inner join examen_postulante EP on 
				GI.vectorExamenPostulante like concat('%',EP.codExamenPostulante,',%')
			or 	GI.vectorExamenPostulante like concat('%,',EP.codExamenPostulante,'%')
			INNER join observacion O on O.codObservacion = GI.codObservacion
			where O.codObservacion = NEW.codObservacion
		);

	-- consulta select que retorna la lista de examen_postulante que están involucrados en cierta observacion de tipo PostulantesElevados
	declare cursor_examenPostulante_postulanteselevados CURSOR FOR (
		select PE.codPostulanteElevado, EP.codExamenPostulante, O.codObservacion from postulantes_elevados PE
			inner join examen_postulante EP on 
				PE.vectorExamenPostulante like concat('%',EP.codExamenPostulante,',%')
			or 	PE.vectorExamenPostulante like concat('%,',EP.codExamenPostulante,'%')
			INNER join observacion O on O.codObservacion = PE.codObservacion
			where O.codObservacion = NEW.codObservacion
		);
	-- 
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET var_final = 1;
	
	IF NEW.codEstado = 3 THEN
		case OLD.codTipoObservacion
			WHEN 1 THEN  -- GrupoPatron
							
				open cursor_examenPostulante_grupopatron; -- recorre todos los examenes postulante involucrados en esta observacion
				bucle: LOOP
					-- para detener el recorrido cuando se termine el cursor 
					FETCH cursor_examenPostulante_grupopatron INTO codGrupo, codExamenPostulanteAnulado, codObservacion;
					IF var_final = 1 THEN
						LEAVE bucle;
					END IF;
					
					-- anulamos esa postulacion
					update examen_postulante set codCondicion='6' 
						where codExamenPostulante = codExamenPostulanteAnulado;
				END LOOP bucle;
				CLOSE cursor_examenPostulante_grupopatron;
			WHEN 2 THEN-- GrupoIguales
								
				open cursor_examenPostulante_grupoiguales; -- recorre todos los examenes postulante involucrados en esta observacion
				bucle: LOOP
					-- para detener el recorrido cuando se termine el cursor 
					FETCH cursor_examenPostulante_grupoiguales INTO codGrupo, codExamenPostulanteAnulado, codObservacion;
					IF var_final = 1 THEN
						LEAVE bucle;
					END IF;
					
					-- anulamos esa postulacion
					update examen_postulante set codCondicion='6' 
						where codExamenPostulante = codExamenPostulanteAnulado;
				END LOOP bucle;
				CLOSE cursor_examenPostulante_grupoiguales;

			WHEN 3 THEN -- PostulantesElevados
								
				open cursor_examenPostulante_postulanteselevados; -- recorre todos los examenes postulante involucrados en esta observacion
				bucle: LOOP
					-- para detener el recorrido cuando se termine el cursor 
					FETCH cursor_examenPostulante_postulanteselevados INTO codGrupo, codExamenPostulanteAnulado, codObservacion;
					IF var_final = 1 THEN
						LEAVE bucle;
					END IF;
					
					-- anulamos esa postulacion
					update examen_postulante set codCondicion='6' 
						where codExamenPostulante = codExamenPostulanteAnulado;
				END LOOP bucle;
				CLOSE cursor_examenPostulante_postulanteselevados;
		end case;
	END IF ;
END


