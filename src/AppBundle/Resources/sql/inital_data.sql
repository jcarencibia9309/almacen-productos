INSERT INTO `almacen`.`nestado_proceso` (`id`, `nombre`, `descripcion`, `activo`) VALUES (1, 'Iniciada', NULL, 1);
INSERT INTO `almacen`.`nestado_proceso` (`id`, `nombre`, `descripcion`, `activo`) VALUES (2, 'Completada', NULL, 1);


INSERT INTO `almacen`.`ncategoria` (`id`, `nombre`, `descripcion`, `activo`) VALUES (1, 'Carnes', 'Carnes', 1);
INSERT INTO `almacen`.`ncategoria` (`id`, `nombre`, `descripcion`, `activo`) VALUES (2, 'Electrodomésticos', 'Electrodomésticos', 1);
INSERT INTO `almacen`.`ncategoria` (`id`, `nombre`, `descripcion`, `activo`) VALUES (3, 'Aseo', 'Aseo', 1);

ALTER TABLE `almacen`.`nestado_proceso` AUTO_INCREMENT = 3;
ALTER TABLE `almacen`.`ncategoria` AUTO_INCREMENT = 4;
