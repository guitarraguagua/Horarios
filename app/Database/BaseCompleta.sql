-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema Horarios
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Horarios
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Horarios` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `Horarios` ;

-- -----------------------------------------------------
-- Table `Horarios`.`Salas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Horarios`.`Salas` (
  `idSala` VARCHAR(20) NOT NULL,
  `capacidad` INT NULL DEFAULT NULL,
  `ubicacion` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idSala`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `Horarios`.`DISPONIBILIDAD_SALAS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Horarios`.`DISPONIBILIDAD_SALAS` (
  `idSala` VARCHAR(20) CHARACTER SET 'utf8mb3' NOT NULL,
  `dia` VARCHAR(45) NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NULL DEFAULT NULL,
  `estado` VARCHAR(40) NULL DEFAULT 'DISPONIBLE',
  `semestre` INT NOT NULL,
  `idRamos_Profesor` INT NULL DEFAULT NULL,
  PRIMARY KEY (`idSala`, `dia`, `hora_inicio`, `semestre`),
  CONSTRAINT `fk_sala`
    FOREIGN KEY (`idSala`)
    REFERENCES `Horarios`.`Salas` (`idSala`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `Horarios`.`Ramos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Horarios`.`Ramos` (
  `idRamo` VARCHAR(50) NOT NULL,
  `nombre` VARCHAR(120) NULL DEFAULT NULL,
  `horas_catedra` INT NULL DEFAULT NULL,
  `horas_laboratorio` INT NULL DEFAULT NULL,
  `semestre` INT NULL DEFAULT NULL,
  `cantidad_alumnos` INT NULL DEFAULT NULL,
  PRIMARY KEY (`idRamo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `Horarios`.`Profesores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Horarios`.`Profesores` (
  `profesor_rut` VARCHAR(10) NOT NULL,
  `nombre` VARCHAR(50) NULL DEFAULT NULL,
  `apellido_paterno` VARCHAR(50) NULL DEFAULT NULL,
  `apellido_materno` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`profesor_rut`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `Horarios`.`Ramos_Profesores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Horarios`.`Ramos_Profesores` (
  `idRamos_Profesor` INT NOT NULL,
  `idRamo` VARCHAR(50) NOT NULL,
  `profesor_rut` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`idRamos_Profesor`),
  INDEX `idRamo_idx` (`idRamo` ASC) VISIBLE,
  INDEX `profesor_rut_idx` (`profesor_rut` ASC) VISIBLE,
  CONSTRAINT `idRamo`
    FOREIGN KEY (`idRamo`)
    REFERENCES `Horarios`.`Ramos` (`idRamo`),
  CONSTRAINT `profesor_rut`
    FOREIGN KEY (`profesor_rut`)
    REFERENCES `Horarios`.`Profesores` (`profesor_rut`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `Horarios`.`Horarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Horarios`.`Horarios` (
  `dia` VARCHAR(45) NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NULL DEFAULT NULL,
  `idSala` VARCHAR(20) NOT NULL,
  `idRamo_Profesor` INT NOT NULL,
  `semestre` INT NOT NULL,
  PRIMARY KEY (`dia`, `hora_inicio`, `idSala`, `idRamo_Profesor`, `semestre`),
  INDEX `idSala_idx` (`idSala` ASC) VISIBLE,
  INDEX `idRamo_Profesor_idx` (`idRamo_Profesor` ASC) VISIBLE,
  CONSTRAINT `idRamo_Profesor`
    FOREIGN KEY (`idRamo_Profesor`)
    REFERENCES `Horarios`.`Ramos_Profesores` (`idRamos_Profesor`),
  CONSTRAINT `idSala`
    FOREIGN KEY (`idSala`)
    REFERENCES `Horarios`.`Salas` (`idSala`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;

USE `Horarios` ;

-- -----------------------------------------------------
-- procedure SP_GENERAR_DISPONIBILIDAD_SALAS
-- -----------------------------------------------------

DELIMITER $$
USE `Horarios`$$
CREATE DEFINER=`root`@`%` PROCEDURE `SP_GENERAR_DISPONIBILIDAD_SALAS`()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_idSala VARCHAR(20);
    DECLARE v_dia VARCHAR(45);
    DECLARE v_hora_inicio TIME;
    DECLARE v_hora_fin TIME;
    DECLARE v_semestre INT;
    
    -- Variables para el bucle de salas
    DECLARE cur_salas CURSOR FOR 
        SELECT idSala FROM `Horarios`.`Salas` WHERE idSala != 'ALMUERZO';
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Limpiar tabla existente
    DELETE FROM `Horarios`.`DISPONIBILIDAD_SALAS`;

    -- Abrir cursor de salas
    OPEN cur_salas;
    
    sala_loop: LOOP
        FETCH cur_salas INTO v_idSala;
        
        IF done THEN
            LEAVE sala_loop;
        END IF;
        
        -- Para cada sala, generar horarios para semestre 1 y 2
        SET v_semestre = 1;
        WHILE v_semestre <= 2 DO
            
            -- Bucle para los 5 días de la semana
            SET @dia_num = 1;
            WHILE @dia_num <= 5 DO
                SET v_dia = CASE @dia_num
                    WHEN 1 THEN 'Lunes'
                    WHEN 2 THEN 'Martes'
                    WHEN 3 THEN 'Miércoles'
                    WHEN 4 THEN 'Jueves'
                    WHEN 5 THEN 'Viernes'
                END;
                
                -- Insertar todos los bloques horarios (excluyendo almuerzo)
                INSERT INTO `Horarios`.`DISPONIBILIDAD_SALAS` 
                    (idSala, dia, hora_inicio, hora_fin, estado, semestre)
                VALUES 
                    (v_idSala, v_dia, '08:30:00', '09:30:00', 'DISPONIBLE', v_semestre),
                    (v_idSala, v_dia, '09:35:00', '10:35:00', 'DISPONIBLE', v_semestre),
                    (v_idSala, v_dia, '10:50:00', '11:50:00', 'DISPONIBLE', v_semestre),
                    (v_idSala, v_dia, '11:55:00', '12:55:00', 'DISPONIBLE', v_semestre),
                    (v_idSala, v_dia, '13:10:00', '14:10:00', 'DISPONIBLE', v_semestre),
                    (v_idSala, v_dia, '14:30:00', '15:30:00', 'DISPONIBLE', v_semestre),
                    (v_idSala, v_dia, '15:35:00', '16:35:00', 'DISPONIBLE', v_semestre),
                    (v_idSala, v_dia, '16:50:00', '17:50:00', 'DISPONIBLE', v_semestre),
                    (v_idSala, v_dia, '17:55:00', '18:55:00', 'DISPONIBLE', v_semestre);
                
                SET @dia_num = @dia_num + 1;
            END WHILE;
            
            SET v_semestre = v_semestre + 1;
        END WHILE;
        
    END LOOP sala_loop;
    
    CLOSE cur_salas;
    
    -- Mensaje de resultado
    SELECT CONCAT('Tabla DISPONIBILIDAD_SALAS generada con ', 
                  (SELECT COUNT(*) FROM `Horarios`.`DISPONIBILIDAD_SALAS`), 
                  ' registros para semestres 1 y 2') AS resultado;
    
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure SP_GENERAR_HORARIOS
-- -----------------------------------------------------

DELIMITER $$
USE `Horarios`$$
CREATE DEFINER=`root`@`%` PROCEDURE `SP_GENERAR_HORARIOS`()
BEGIN
    -- Variables
    DECLARE v_semestre INT DEFAULT 1;
    DECLARE v_semestre_parOimpar INT DEFAULT 1; -- 1 para impar, 2 para par
    DECLARE v_idRamo_Profesor INT;
    DECLARE v_nombre_profesor VARCHAR(100);
    DECLARE v_nombre_ramo VARCHAR(100);
    DECLARE v_horas_semanales INT;
    DECLARE v_cantidad_alumnos INT;
    DECLARE v_capacidad_sala INT;
    DECLARE v_dia INT;
    DECLARE v_dia_nombre VARCHAR(45);
    DECLARE v_hora_inicio TIME;
    DECLARE v_hora_fin TIME;
    DECLARE v_idSala VARCHAR(20);
    DECLARE v_for INT DEFAULT 1;
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_sala_encontrada INT DEFAULT 0;
    DECLARE v_bloques INT DEFAULT 0;

    DECLARE cur CURSOR FOR 
        SELECT  rp.idRamos_Profesor, 
                p.profesor_rut, 
                r.idRamo, 
                ROUND(r.horas_catedra / 14) horas_semanales,
                r.cantidad_alumnos, 
                r.semestre
        FROM Ramos_Profesores rp 
        JOIN Ramos r ON rp.idRamo = r.idRamo
        JOIN Profesores p ON rp.profesor_rut = p.profesor_rut
        order by profesor_rut, idRamo;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    truncate table Horarios; -- Limpiar tabla de horarios antes de insertar nuevos datos
    truncate table DISPONIBILIDAD_SALAS; -- Limpiar tabla de disponibilidad de salas antes de insertar nuevos datos

    call SP_GENERAR_DISPONIBILIDAD_SALAS(); -- Llamar al procedimiento que genera la disponibilidad de salas
    -- call SP_LLENA_HORARIO(); -- Llamar al procedimiento que llena los horarios por defecto

    -- trabajar en los datos del cursor 
    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO v_idRamo_Profesor, v_nombre_profesor, v_nombre_ramo, v_horas_semanales, v_cantidad_alumnos, v_semestre;

        #if v_nombre_ramo = 'INF-103' THEN
        #    SET done = TRUE;
        #END IF;

        IF done THEN
            LEAVE read_loop;
        END IF;

        WHILE v_for <= v_horas_semanales DO
            -- Saber si el semestre es par para trabajar con la disponibilidad de las salas que estan con semestre 1 o 2
            IF v_semestre % 2 = 0 THEN
                SET v_semestre_parOimpar = 2; -- Semestre par
            ELSE
                SET v_semestre_parOimpar = 1; -- Semestre impar
            END IF;
        
            -- Trabajar primero con la disponibilidad de las salas
            SET v_sala_encontrada = 0; -- Resetear la variable de sala encontrada
            BEGIN
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_sala_encontrada = 0;
                                               
                SELECT  ds.idSala, 
                        dia dia_nombre,
                        CASE dia
                            WHEN 'Lunes' THEN 1
                            WHEN 'Martes' THEN 2
                            WHEN 'Miércoles' THEN 3
                            WHEN 'Jueves' THEN 4
                            WHEN 'Viernes' THEN 5
                        END dia, 
                        hora_inicio, 
                        hora_fin, 
                        s.capacidad
                INTO    v_idSala, 
                        v_dia_nombre,
                        v_dia, 
                        v_hora_inicio, 
                        v_hora_fin, 
                        v_capacidad_sala
                FROM DISPONIBILIDAD_SALAS ds JOIN Salas s ON ds.idSala = s.idSala
                WHERE estado = 'DISPONIBLE'
                AND semestre = v_semestre_parOimpar
                AND ds.idSala != 'ALMUERZO'
                AND capacidad >= v_cantidad_alumnos
                and idRamos_Profesor is null
                and dia not in (SELECT dia
								FROM DISPONIBILIDAD_SALAS ds
								where idRamos_Profesor = v_idRamo_Profesor
								and semestre = v_semestre_parOimpar
								group by dia
								having count(*) > 1)
                and dia not in (SELECT dia
								FROM DISPONIBILIDAD_SALAS ds
								JOIN Ramos_Profesores rp on rp.idRamos_Profesor = ds.idRamos_Profesor
								join Ramos r on rp.idRamo = r.idRamo
								join Profesores p on rp.profesor_rut = p.profesor_rut
								where estado = 'OCUPADO'
								and r.idRamo like concat(left(v_nombre_ramo, 5), '%')
								and ds.semestre = v_semestre
								group by dia
								having count(*) > 5)
                ORDER BY capacidad, ds.idSala, dia, hora_inicio
                LIMIT 1;
            
                SET v_sala_encontrada = 1;
            END;

            -- Verificar si se encontró resultado
            IF v_sala_encontrada = 1 THEN

                UPDATE DISPONIBILIDAD_SALAS
                SET estado = 'OCUPADO',
					idRamos_Profesor = v_idRamo_Profesor
                WHERE idSala = v_idSala
                AND semestre = v_semestre_parOimpar
                AND dia = v_dia_nombre
                AND hora_inicio = v_hora_inicio;

            ELSE
                -- No se encontró sala disponible
                SELECT  'No hay sala disponible'  AS debug_message;
            END IF;

            SET v_for = v_for + 1;
        END WHILE;
        SET v_for = 1;

    END LOOP read_loop;
    CLOSE cur;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure SP_LLENA_HORARIO
-- -----------------------------------------------------

DELIMITER $$
USE `Horarios`$$
CREATE DEFINER=`root`@`%` PROCEDURE `SP_LLENA_HORARIO`()
BEGIN
    DECLARE dia INT DEFAULT 1;
    DECLARE semestre INT DEFAULT 1;
    DECLARE v_dia VARCHAR(45);
    DECLARE v_hora_inicio TIME;
    DECLARE v_hora_fin TIME;
    DECLARE v_idSala VARCHAR(10);
    DECLARE v_estado VARCHAR(20);
    DECLARE v_idRamo_Profesor INT DEFAULT 0;
    DECLARE bloque_num INT DEFAULT 1;

	truncate table Horarios;
    
    -- Crear datos por defecto si no existen
    INSERT IGNORE INTO `Horarios`.`Profesores` (profesor_rut, nombre, apellido_paterno, apellido_materno)
    VALUES ('0000000000', 'SIN', 'ASIGNAR', 'PROFESOR');

    INSERT IGNORE INTO `Horarios`.`Ramos` (idRamo, nombre, horas_catedra, horas_laboratorio, semestre, cantidad_alumnos)
    VALUES ('SIN_RAMO', 'Sin ramo asignado', 0, 0, 0, 0);

    INSERT IGNORE INTO `Horarios`.`Ramos_Profesores` (idRamos_Profesor, idRamo, profesor_rut)
    VALUES (0, 'SIN_RAMO', '0000000000');

    INSERT IGNORE INTO `Horarios`.`Salas` (idSala, capacidad, ubicacion)
    VALUES ('DEFAULT', 30, 'Sala por defecto'),
           ('ALMUERZO', 0, 'Comedor Principal');

    -- Limpiar tabla de horarios existentes
    DELETE FROM `Horarios`.`Horarios`;

    -- Bucle para los 11 semestres
    WHILE semestre <= 11 DO
        
        -- Bucle para los 5 días de la semana
        SET dia = 1;
        WHILE dia <= 5 DO
            SET v_dia = CASE dia
                WHEN 1 THEN 'Lunes'
                WHEN 2 THEN 'Martes'
                WHEN 3 THEN 'Miércoles'
                WHEN 4 THEN 'Jueves'
                WHEN 5 THEN 'Viernes'
            END;
            
            SET bloque_num = 1;
            
            -- Definir los horarios exactos según tu patrón
            WHILE bloque_num <= 11 DO -- 10 bloques + 1 almuerzo = 11 total
                
                CASE bloque_num
                    WHEN 1 THEN 
                        SET v_hora_inicio = '08:30:00';
                        SET v_hora_fin = '09:30:00';
                        SET v_idSala = 'DEFAULT';
                        SET v_estado = 'DISPONIBLE';
                    
                    WHEN 2 THEN 
                        SET v_hora_inicio = '09:35:00';
                        SET v_hora_fin = '10:35:00';
                        SET v_idSala = 'DEFAULT';
                        SET v_estado = 'DISPONIBLE';
                    
                    WHEN 3 THEN 
                        SET v_hora_inicio = '10:50:00';
                        SET v_hora_fin = '11:50:00';
                        SET v_idSala = 'DEFAULT';
                        SET v_estado = 'DISPONIBLE';
                    
                    WHEN 4 THEN 
                        SET v_hora_inicio = '11:55:00';
                        SET v_hora_fin = '12:55:00';
                        SET v_idSala = 'DEFAULT';
                        SET v_estado = 'DISPONIBLE';
                    
                    WHEN 5 THEN 
                        SET v_hora_inicio = '13:10:00';
                        SET v_hora_fin = '14:10:00';
                        SET v_idSala = 'DEFAULT';
                        SET v_estado = 'DISPONIBLE';
                    
                    WHEN 6 THEN 
                        SET v_hora_inicio = '14:10:00';
                        SET v_hora_fin = '14:30:00';
                        SET v_idSala = 'ALMUERZO';
                        SET v_estado = 'ALMUERZO';
                    
                    WHEN 7 THEN 
                        SET v_hora_inicio = '14:30:00';
                        SET v_hora_fin = '15:30:00';
                        SET v_idSala = 'DEFAULT';
                        SET v_estado = 'DISPONIBLE';
                    
                    WHEN 8 THEN 
                        SET v_hora_inicio = '15:35:00';
                        SET v_hora_fin = '16:35:00';
                        SET v_idSala = 'DEFAULT';
                        SET v_estado = 'DISPONIBLE';
                    
                    WHEN 9 THEN 
                        SET v_hora_inicio = '16:50:00';
                        SET v_hora_fin = '17:50:00';
                        SET v_idSala = 'DEFAULT';
                        SET v_estado = 'DISPONIBLE';
                    
                    WHEN 10 THEN 
                        SET v_hora_inicio = '17:55:00';
                        SET v_hora_fin = '18:55:00';
                        SET v_idSala = 'DEFAULT';
                        SET v_estado = 'DISPONIBLE';
                    
                    ELSE 
                        SET bloque_num = 12; -- Salir del bucle
                END CASE;
                
                -- Insertar el bloque si no se excedió el límite
                IF bloque_num <= 10 THEN
                    INSERT INTO `Horarios`.`Horarios` (dia, hora_inicio, hora_fin, idSala, idRamo_Profesor, estado, semestre)
                    VALUES (v_dia, v_hora_inicio, v_hora_fin, v_idSala, v_idRamo_Profesor, v_estado, semestre);
                END IF;
                
                SET bloque_num = bloque_num + 1;
            END WHILE;
            
            SET dia = dia + 1;
        END WHILE;
        
        SET semestre = semestre + 1;
    END WHILE;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure SP_OBTENER_HORARIOS
-- -----------------------------------------------------

DELIMITER $$
USE `Horarios`$$
CREATE DEFINER=`root`@`%` PROCEDURE `SP_OBTENER_HORARIOS`()
BEGIN	
    SELECT ds.dia AS dia_nombre,
			   CASE ds.dia
				   WHEN 'Lunes' THEN 1
				   WHEN 'Martes' THEN 2
				   WHEN 'Miércoles' THEN 3
				   WHEN 'Jueves' THEN 4
				   WHEN 'Viernes' THEN 5
			   END AS dia,
			   ds.hora_inicio,
			   ds.hora_fin,
			   ds.idSala,
			   r.nombre,
               CONCAT(CONCAT(CONCAT(CONCAT(p.nombre, ' '), p.apellido_paterno), ' '), p.apellido_materno) AS docente,
			   r.semestre
        FROM Horarios.DISPONIBILIDAD_SALAS ds
        JOIN Horarios.Ramos_Profesores rp ON ds.idRamos_Profesor = rp.idRamos_Profesor
        join Horarios.Ramos r on rp.idRamo = r.idRamo
        join Horarios.Profesores p on rp.profesor_rut = p.profesor_rut
        WHERE ds.idRamos_Profesor IS NOT NULL
        ORDER BY semestre, dia, hora_inicio;
END$$

DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
