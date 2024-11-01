-- Active: 1727879607945@@127.0.0.1@3306@bienesraices

CREATE DATABASE bienesraices;

USE bienesraices;


CREATE TABLE `propiedades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(60) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `descripcion` longtext,
  `habitaciones` int(11) DEFAULT NULL,
  `wc` int(11) DEFAULT NULL,
  `estacionamiento` int(11) DEFAULT NULL,
  `vendedorId` int(11) DEFAULT NULL,
  `creado` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vendedorId_idx` (`vendedorId`),
  CONSTRAINT `vendedorId` FOREIGN KEY (`vendedorId`) REFERENCES `vendedores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) DEFAULT NULL,
  `password` char(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `vendedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE propiedadesVendidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    propiedad_id INT NOT NULL,
    comprador VARCHAR(100) NOT NULL,
    fecha_venta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (propiedad_id) REFERENCES propiedades(id) ON DELETE CASCADE
);


INSERT INTO `propiedades` (`id`, `titulo`, `precio`, `imagen`, `descripcion`, `habitaciones`, `wc`, `estacionamiento`, `vendedorId`, `creado`) VALUES
(67, 'Cueva de la Soledad', 12000.00, 'anuncio1.jpg', 'dio consectetur at. Interdum et malesuada fames ac ante ipsum primis in faucibus.', 1, 2, 3, 1, '2021-02-05'),
(68, 'Mansion Wayne', 130000.00, 'anuncio2.jpg', 'dio consectetur at. Interdum et malesuada fames ac ante ipsum primis in faucibus.', 3, 2, 1, 1, '2021-02-05'),
(69, 'Mansion Stark', 135800.00, 'anuncio3.jpg', 'dio consectetur at. Interdum et malesuada fames ac ante ipsum primis in faucibus.', 3, 1, 2, 1, '2021-02-05'),
(70, 'Atalaya', 10000.00, 'anuncio4.jpg', 'dio consectetur at. Interdum et malesuada fames ac ante ipsum primis in faucibus.', 3, 2, 1, 1, '2021-02-05'),
(72, 'Green Hell', 16000.00, 'anuncio6.jpg', 'dio consectetur at. Interdum et malesuada fames ac ante ipsum primis in faucibus.', 3, 2, 1, 1, '2021-02-05')

INSERT INTO `usuarios` (`id`, `email`, `password`) VALUES
(5, 'correo@correo.com', '$2y$10$qb.EdDL1jR/Jc6JGFy9fT.t054KASVYqSWeqJHknF9ETutIb1AI4W');

INSERT INTO `vendedores` (`id`, `nombre`, `apellido`, `telefono`) VALUES
(1, 'Juan', 'De la torre', '091390109'),
(2, 'KAREN ACT', 'Perez', '0123456789');

