USE PROJECTDB;

INSERT INTO agencia (id_agencia, provincia, numero_sede, direccion, telefono) VALUES
(1001, 'Lima', '1', 'Av. Principal 123', '992384473'),
(1002, 'Arequipa', '1', 'Calle Secundaria 456', '962622678'),
(1003, 'Tacna', '1', 'Av. Central 789', '999263920'),
(1004, 'Cusco', '1', 'Calle Mayor 101', '901833999'),
(1005, 'Trujillo', '1', 'Av. 5ta 202', '913277828'),
(1006, 'Lima', '2', 'Av. Principal 123', '992384473'),
(1007, 'Arequipa', '2', 'Calle Secundaria 456', '962622678'),
(1008, 'Tacna', '2', 'Av. Central 789', '999263920'),
(1009, 'Cusco', '2', 'Calle Mayor 101', '901833999'),
(1010, 'Trujillo', '2', 'Av. 5ta 202', '913277828');


INSERT INTO empleado (id_empleado, nombre, clave, telefono, id_agencia) VALUES
(2001, 'Ana Vargas', 'WBDKAK', '987654321',1001),
(2002, 'Luis Fernández', 'DHSGAJ', '987654322',1002),
(2003, 'María Gómez', 'CLOSDD', '987654323',1003),
(2004, 'Carlos Ruiz', 'ODJSAB', '987654324',1004),
(2005, 'Paola Fernández', 'QKFSNE', '987654325',1005),
(2006, 'Juana Vargas', 'WBDzAK', '988784321',1001),
(2007, 'Cesar Fernández', 'DzSGAJ', '981214322',1002),
(2008, 'Mariano Gómez', 'CLAAAD', '987654310',1003),
(2009, 'Carlthon Drake', 'POJOAB', '910654324',1004),
(2010, 'Pedro Aquino', 'KONZZZ', '913654325',1005);

INSERT INTO usuario (num_documento, tipo_documento, nombre, telefono) VALUES
('60345678', 'DNI', 'Juan Carlos Mendoza', '987657747'),
('87654321', 'DNI', 'Ana María Ríos', '991372888'),
('23456789', 'DNI', 'Luis Fernando García', '913728773'),
('78567890', 'DNI', 'María Elena Morales', '987333234'),
('45678901', 'DNI', 'Carlos Alberto Pérez', '979283748'),
('77345678', 'DNI', 'Sofía Hernández', '999122321'),
('60444321', 'DNI', 'Pedro Antonio López', '911124322'),
('78456203', 'DNI', 'Laura Gómez Ruiz', '988114323'),
('34567890', 'DNI', 'Jorge Luis Martínez', '911382934'),
('71678901', 'DNI', 'Isabel Cristina Fernández', '991238933');

INSERT INTO transporte (id_transporte, tipo_transporte, numero_placa, id_agencia) VALUES
(3001, 'Camión', 'FGY727', 1001),
(3002, 'Camión', 'KHS821', 1002),
(3003, 'Camión', 'KQI112', 1003),
(3004, 'Camión', 'GAY001', 1004),
(3005, 'Camión', 'KEY666', 1005);


INSERT INTO envio (clave, origen, destino, u_remitente, u_destinatario, modalidad_envio, modalidad_entrega, id_transporte) VALUES
('EN01', 1001, 1002, '60345678', '87654321', 'Terrestre', 'Directa', 3001),
('EN02', 1002, 1003, '23456789', '78567890', 'Terrestre', 'Directa', 3002),
('EN03', 1003, 1004, '45678901', '77345678', 'Terrestre', 'Directa', 3003),
('EN04', 1004, 1005, '60444321', '78456203', 'Terrestre', 'Directa', 3004),
('EN05', 1005, 1001, '34567890', '71678901', 'Terrestre', 'Directa', 3005);

INSERT INTO paquete (tipo_contenido, peso, dimenciones, estado_paquete, id_envio) VALUES
('Electrónico', 1.50, 'S', 'aceptado', 1),
('Ropa', 2.00, 'M', 'aceptado', 2),
('Libros', 3.00, 'L','en espera', 3),
('Electrodomésticos', 4.50, 'XL', 'en espera', 4),
('Comestibles', 2.50, 'M', 'en espera', 5),
('Electrónico', 1.50, 'S', 'en espera', 1),
('Ropa', 2.00, 'M', 'en espera', 2),
('Libros', 3.00, 'L','en espera', 3),
('Electrodomésticos', 4.50, 'XL', 'en espera', 4),
('Comestibles', 2.50, 'M', 'en espera', 5);

INSERT INTO detalle (id_envio) VALUES
(1),
(2),
(3),
(4),
(5);

INSERT INTO pago (id_orden, modalidad_pago, metodo_pago, responsable_pago, estado, costo_total) VALUES
(1, 'En efectivo', 'N/A', 'Ana Vargas', 'Pagado', 100),
(2, 'Tarjeta de crédito', 'Visa', 'Luis Fernández', 'Pagado', 150),
(3, 'En efectivo', 'N/A', 'María Gómez', 'Pendiente', 200),
(4, 'Tarjeta de crédito', 'MasterCard', 'Carlos Ruiz', 'Pagado', 250),
(5, 'Transferencia bancaria', 'N/A', 'Paola Fernández', 'Pendiente', 175);

INSERT INTO estado (id_envio, situacion_actual) VALUES
(1, 'En tránsito'),
(2, 'Entregado'),
(3, 'En almacén'),
(4, 'En tránsito'),
(5, 'En tránsito');

INSERT INTO rastrea (id_envio, doc_remitente, doc_destinatario) VALUES
(1, '60345678', '87654321'),
(2, '23456789', '78567890'),
(3, '45678901', '77345678'),
(4, '60444321', '78456203'),
(5, '34567890', '71678901');
