CREATE DEFINER=`root`@`localhost` FUNCTION `obtenerRespuestas`(codExamenBuscado INT ) RETURNS varchar(300) CHARSET utf8mb4
BEGIN
	declare preguntas varchar(300);
    declare respuesta varchar(1);
    DECLARE var_final INTEGER DEFAULT 0;
    declare cursor_preguntas CURSOR FOR (select respuestaCorrecta 
            from pregunta where codExamen=codExamenBuscado);
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET var_final = 1;

    open cursor_preguntas;
    set preguntas='_';
	bucle: LOOP
		-- para detener el recorrido cuando se termine el cursor
        FETCH cursor_preguntas INTO respuesta;
		IF var_final = 1 THEN
		  LEAVE bucle;
		END IF;
		
		set preguntas = concat(preguntas,respuesta);
        
		
	END LOOP bucle;
	CLOSE cursor_preguntas;
    return preguntas;
END