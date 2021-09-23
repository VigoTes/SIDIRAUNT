# Privileges for `anonimo`@`localhost`

GRANT USAGE ON *.* TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`carrera` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`condicion_postulacion` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`area` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`pregunta` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`parametros` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`facultad` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`sede` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`actor` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`carrera_examen` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`usuario` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`examen_postulante` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`estado_examen` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`examen` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`tipo_actor` TO 'anonimo'@'localhost';

GRANT SELECT ON `sidiraunt`.`modalidad` TO 'anonimo'@'localhost';


# Privileges for `director`@`localhost`

GRANT USAGE ON *.* TO 'director'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE ON `sidiraunt`.* TO 'director'@'localhost';


# Privileges for `postulante`@`localhost`

GRANT USAGE ON *.* TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`actor` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`modalidad` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`parametros` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`facultad` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`estado_examen` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`sede` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`examen_postulante` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`usuario` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`area` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`carrera_examen` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`carrera` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`pregunta` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`condicion_postulacion` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`examen` TO 'postulante'@'localhost';

GRANT SELECT ON `sidiraunt`.`tipo_actor` TO 'postulante'@'localhost';


# Privileges for `representante`@`localhost`

GRANT USAGE ON *.* TO 'representante'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE ON `sidiraunt`.* TO 'representante'@'localhost';