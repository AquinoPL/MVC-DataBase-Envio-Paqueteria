CREATE DATABASE PROJECTDB;
USE PROJECTDB;

CREATE TABLE agencia(
	id_agencia INT(8) AUTO_INCREMENT PRIMARY KEY,
	provincia VARCHAR(20) NOT NULL,
    numero_sede VARCHAR(15) NOT NULL,
    direccion VARCHAR(30) NOT NULL,
    telefono CHAR(9) DEFAULT NULL
);

CREATE TABLE empleado(
	id_empleado INT(8)  AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL,
    clave CHAR(6) NOT NULL,
	telefono CHAR(9) DEFAULT NULL,
    id_agencia INT(8) NOT NULL,
    FOREIGN KEY (id_agencia) REFERENCES agencia (id_agencia) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE usuario(
	num_documento CHAR(8)  PRIMARY KEY,
    tipo_documento VARCHAR(3) NOT NULL,
    nombre VARCHAR(40) NOT NULL,
	telefono CHAR(9) DEFAULT NULL
);

CREATE TABLE transporte(
	id_transporte INT(8)  AUTO_INCREMENT PRIMARY KEY,
    tipo_transporte VARCHAR(20) NOT NULL,
    numero_placa CHAR(6) DEFAULT NULL,
    id_agencia INT(8) NOT NULL,
    FOREIGN KEY (id_agencia) REFERENCES agencia (id_agencia) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE envio(
    id_envio INT(8) AUTO_INCREMENT PRIMARY KEY,
	clave CHAR(4) NOT NULL,
    origen INT(8) NOT NULL,
    destino INT(8) NOT NULL,
    u_remitente CHAR(8) NOT NULL,
	u_destinatario CHAR(8) NOT NULL,
	modalidad_envio VARCHAR(20) NOT NULL,
    modalidad_entrega VARCHAR(20) NOT NULL,
    id_transporte INT(8) NOT NULL,
    FOREIGN KEY (origen) REFERENCES agencia (id_agencia) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (destino) REFERENCES agencia (id_agencia) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (u_remitente) REFERENCES usuario (num_documento) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (u_destinatario) REFERENCES usuario (num_documento) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (id_transporte) REFERENCES transporte (id_transporte) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE paquete(
	id_paquete INT(8) AUTO_INCREMENT PRIMARY KEY,
    tipo_contenido VARCHAR(20) NOT NULL,
    peso DECIMAL(3,2) NOT NULL,
    dimenciones VARCHAR(30) NOT NULL,
    estado_paquete VARCHAR(20) NOT NULL,
    id_envio INT(8) NOT NULL,
    FOREIGN KEY (id_envio) REFERENCES envio (id_envio) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE detalle(
	id_orden INT(8) AUTO_INCREMENT PRIMARY KEY,
    fecha_registro DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_entrega DATE DEFAULT NULL,
    id_envio INT(8) NOT NULL,
    FOREIGN KEY (id_envio) REFERENCES envio (id_envio) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE pago(
    id_orden INT(8) PRIMARY KEY,
    modalidad_pago VARCHAR(20) NOT NULL,
    metodo_pago VARCHAR(15) DEFAULT NULL,
    responsable_pago VARCHAR(20) NOT NULL,
    estado VARCHAR(15) NOT NULL,
    costo_total INT(4) NOT NULL,
    FOREIGN KEY (id_orden) REFERENCES detalle (id_orden) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE estado(
	id_envio INT(8) PRIMARY KEY,
    situacion_actual VARCHAR(30) NOT NULL,
    FOREIGN KEY (id_envio) REFERENCES envio (id_envio) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE rastrea(
	id_envio INT(8)  PRIMARY KEY,
    doc_remitente CHAR(8) NOT NULL,
    doc_destinatario CHAR(8) NOT NULL,
    FOREIGN KEY (id_envio) REFERENCES envio (id_envio) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (doc_remitente) REFERENCES usuario (num_documento) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (doc_destinatario) REFERENCES usuario (num_documento) ON DELETE CASCADE ON UPDATE CASCADE
);