/* 
 * Tablas
 */
CREATE TABLE `pais` (
`ID_PAIS`                  VARCHAR(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código ISO 3166-1 alfa-2 ',
`NOMBRE`                   VARCHAR(300) COLLATE utf8_unicode_ci NOT NULL,
`ORDEN`                    tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`ID_PAIS`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `region` (
`ID_REGION`                INT(11) NOT NULL AUTO_INCREMENT,
`ID_PAIS`                  VARCHAR(2) COLLATE utf8_unicode_ci NOT NULL,
`NOMBRE`                   VARCHAR(300) COLLATE utf8_unicode_ci NOT NULL,
`ORDEN`                    tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`ID_REGION`),
CONSTRAINT `FK_ID_PAIS`  FOREIGN KEY (`ID_PAIS`)  REFERENCES `pais` (`ID_PAIS`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ciudad` (
`ID_PAIS`                  VARCHAR(2) COLLATE utf8_unicode_ci  COMMENT 'Código ISO 3166-1 alfa-2 ',
`ID_REGION`                INT(11) NOT NULL,
`ID_CIUDAD`                INT(11) NOT NULL AUTO_INCREMENT,
`NOMBRE`                   VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
`ORDEN`                    INT(3) NOT NULL DEFAULT '0',
PRIMARY KEY (`ID_CIUDAD`),
CONSTRAINT `FK_ID_REGION`  FOREIGN KEY (`ID_REGION`)  REFERENCES `region` (`ID_REGION`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `automotora` (
`ID_AUTOMOTORA`               INT(11) NOT NULL AUTO_INCREMENT,
`ID_MATRIZ`                   INT(11) NOT NULL COMMENT 'referencia a ID_AUTOMOTORA',
`ID_CIUDAD`                   INT(11) NOT NULL ,
`RUT`                         VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'identificador varchar, unico en chile',
`NOMBRE`                      VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
`EMAIL`                       VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
`IMG`                         VARCHAR(500) COLLATE utf8_unicode_ci default NULL,
`URL`                         TEXT COLLATE utf8_unicode_ci,
`DIRECCION`                   VARCHAR(1000) COLLATE utf8_unicode_ci default NULL,
`HORARIO_LUN_VIE`             VARCHAR(300) COLLATE utf8_unicode_ci default NULL,
`HORARIO_SAB`                 VARCHAR(300) COLLATE utf8_unicode_ci default NULL,
`HORARIO_DOM`                 VARCHAR(300) COLLATE utf8_unicode_ci default NULL,
`MAPA`                        TEXT COLLATE utf8_unicode_ci,
`ESTADO`                      ENUM('activo','inactivo') CHARACTER SET utf8 default 'activo' COMMENT 'flag estado automotora',
`FECHA_INGRESO`               DATETIME    DEFAULT NULL,
`FECHA_MODIFICACION`          DATETIME    DEFAULT NULL,
`SUBDOMINIO`                  VARCHAR(300) COLLATE utf8_unicode_ci default NULL,
`CONT_MINISITIO`              INT(11) NOT NULL ,
`DESTACADA`                   tinyint(1) NOT NULL DEFAULT '0',
`TELEFONO`                    VARCHAR(50) COLLATE utf8_unicode_ci default NULL,
`FAX`                         VARCHAR(50) COLLATE utf8_unicode_ci default NULL,
`RAZON_SOCIAL`                VARCHAR(500) COLLATE utf8_unicode_ci default NULL,
PRIMARY KEY (`ID_AUTOMOTORA`),
CONSTRAINT `FK_ID_CIUDAD`  FOREIGN KEY (`ID_CIUDAD`)  REFERENCES `ciudad` (`ID_CIUDAD`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `vendedor` (
`ID_AUTOMOTORA`               INT(11) NOT NULL,
`ID_VENDEDOR`                 INT(11) NOT NULL AUTO_INCREMENT,
`NOMBRE`                      VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
`APELLIDO_PATERNO`            VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
`APELLIDO_MATERNO`            VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
`RUT`                         VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'identificador varchar, unico en chile',
`EMAIL`                       VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
`PASSWORD`                    VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
`TELEFONO`                    VARCHAR(50) COLLATE utf8_unicode_ci default NULL,
`MOVIL`                       VARCHAR(50) COLLATE utf8_unicode_ci default NULL,
`DIRECCION`                   VARCHAR(50) COLLATE utf8_unicode_ci default NULL COMMENT 'SE PUEDE USAR LA DIRECCION DE LA SUCURSAL',
`FECHA_INGRESO`               DATETIME    DEFAULT NULL,
`FECHA_MODIFICACION`          DATETIME    DEFAULT NULL,
`TIPO`                        ENUM('vendedor','usuario','eliminado') CHARACTER SET utf8  default 'vendedor' COMMENT 'verificar uso',
PRIMARY KEY (`ID_VENDEDOR`),
CONSTRAINT `FK_ID_AUTOMOTORA`  FOREIGN KEY (`ID_AUTOMOTORA`)  REFERENCES `automotora` (`ID_AUTOMOTORA`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `carroceria` (
`ID_CARROCERIA`            INT(11) NOT NULL AUTO_INCREMENT,
`NOMBRE`                   VARCHAR(300) COLLATE utf8_unicode_ci NOT NULL,
`DESCRIPCION`              TEXT COLLATE utf8_unicode_ci,
PRIMARY KEY (`ID_CARROCERIA`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `marca` (
`ID_MARCA`                INT(11) NOT NULL AUTO_INCREMENT,
`NOMBRE`                  VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
`ID_PAIS`                 VARCHAR(2) COLLATE utf8_unicode_ci  COMMENT 'Código ISO 3166-1 alfa-2 ',
PRIMARY KEY (`ID_MARCA`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `modelo` (
`ID_MODELO`               INT(11) NOT NULL AUTO_INCREMENT,
`ID_MARCA`                INT(11) NOT NULL,
`ID_CARROCERIA`           INT(11) NOT NULL,
`NOMBRE`                  VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
`FECHA_ELIMINACION`          DATETIME    DEFAULT NULL,
PRIMARY KEY (`ID_MODELO`),
CONSTRAINT `FK_ID_MARCA`  FOREIGN KEY (`ID_MARCA`)  REFERENCES `marca` (`ID_MARCA`),
CONSTRAINT `FK_ID_CARROCERIA`  FOREIGN KEY (`ID_CARROCERIA`)  REFERENCES `carroceria` (`ID_CARROCERIA`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `vehiculo` (
`ID_AUTOMOTORA`               INT(11) NOT NULL,
`ID_VEHICULO`                 INT(11) NOT NULL AUTO_INCREMENT,
`ID_VENDEDOR`                 INT(11) NOT NULL,
`ID_MARCA`                    INT(11) NOT NULL,
`ID_MODELO`                   INT(11) NOT NULL,
`ID_CARROCERIA`               INT(11) NOT NULL,
`CONT_BUSQUEDA`               INT(11) NOT NULL,
`CONT_FICHA`                  INT(11) NOT NULL,
`CONDICION`                   ENUM('usado','nuevo') CHARACTER SET utf8 default 'usado',
`ESTADO`                      ENUM('eliminado','alta', 'baja', 'vendido') CHARACTER SET utf8 default 'alta' COMMENT 'estado del vehiculo',
`PATENTE`                VARCHAR(50) COLLATE utf8_unicode_ci default NULL,
`ANNIO`                  INT(4) NOT NULL,
`KILOMETROS`             INT(11) NOT NULL,
`PRECIO`                 INT(11) NOT NULL,
`DESCRIPCION`            TEXT COLLATE utf8_unicode_ci,
`FECHA_PUBLICACION`      DATETIME    DEFAULT NULL,
`FECHA_MODIFICACION`     DATETIME    DEFAULT NULL,
`IMG1`                   VARCHAR(500) COLLATE utf8_unicode_ci default NULL,
`IMG2`                   VARCHAR(500) COLLATE utf8_unicode_ci default NULL,
`IMG3`                   VARCHAR(500) COLLATE utf8_unicode_ci default NULL,
`IMG4`                   VARCHAR(500) COLLATE utf8_unicode_ci default NULL,
`IMG5`                   VARCHAR(500) COLLATE utf8_unicode_ci default NULL,
PRIMARY KEY (`ID_VEHICULO`),
CONSTRAINT `FK_V_ID_AUTOMOTORA`  FOREIGN KEY (`ID_AUTOMOTORA`)  REFERENCES `automotora` (`ID_AUTOMOTORA`),
CONSTRAINT `FK_V_ID_VENDEDOR`    FOREIGN KEY (`ID_VENDEDOR`)    REFERENCES `vendedor` (`ID_VENDEDOR`),
CONSTRAINT `FK_V_ID_MARCA`       FOREIGN KEY (`ID_MARCA`)       REFERENCES `marca` (`ID_MARCA`),
CONSTRAINT `FK_V_ID_MODELO`      FOREIGN KEY (`ID_MODELO`)      REFERENCES `modelo` (`ID_MODELO`),
CONSTRAINT `FK_V_ID_CARROCERIA`  FOREIGN KEY (`ID_CARROCERIA`)  REFERENCES `carroceria` (`ID_CARROCERIA`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `atributo` (
`ID_ATRIBUTO`               INT(11) NOT NULL AUTO_INCREMENT,
`NOMBRE`                    VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
`DESCRIPCION`               TEXT COLLATE utf8_unicode_ci,
`TIPO`                      enum('num','txt','sel','opt') CHARACTER SET utf8 default 'txt',
`SECTOR`                    enum('equipo','seguridad','publicacion','general') CHARACTER SET utf8 default 'general',
`ESTADO`                    enum('activo','inactivo') CHARACTER SET utf8 default 'activo',
`CONJUNTO`                  enum('combustible','transmision','etiqueta') CHARACTER SET utf8 default 'etiqueta',
PRIMARY KEY (`ID_ATRIBUTO`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*
<?if($veh_atrb[destacado][id]==21){echo"checked";}?>> Gold</label>
<?if($veh_atrb[destacado][id]==23){echo"checked";}?>> Silver</label>
<?if($veh_atrb[destacado][id]==24){echo"checked";}?>> Bronce</l
*/

CREATE TABLE `atributo_vehiculo` (
`ID_ATRIBUTO`               INT(11) NOT NULL,
`VALOR`                     INT(11) NOT NULL,
`ID_VEHICULO`               INT(11) NOT NULL,
PRIMARY KEY (`ID_ATRIBUTO`, `VALOR`, `ID_VEHICULO`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `desatacado_automotora` (
`ID_AUTOMOTORA`               INT(11) NOT NULL,
`FECHA_INICIO`                DATETIME    DEFAULT NULL,
`FECHA_TERMINO`               DATETIME    DEFAULT NULL,
PRIMARY KEY (`ID_AUTOMOTORA`, `FECHA_INICIO`, `FECHA_TERMINO`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `destacado_vehiculo` (
`ID_VEHICULO`               INT(11) NOT NULL,
`FECHA_INICIO`                DATETIME    DEFAULT NULL,
`FECHA_TERMINO`               DATETIME    DEFAULT NULL,
PRIMARY KEY (`ID_VEHICULO`, `FECHA_INICIO`, `FECHA_TERMINO`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



insert into pais (`ID_PAIS`,`NOMBRE`,`ORDEN`) values ('CL','Chile', 1);

insert into region (`ID_REGION`, `ID_PAIS`,`NOMBRE`,`ORDEN`) values 
(null,'CL', 'Arica y Parinacota', 1),
(null,'CL', 'Tarapacá', 2),
(null,'CL', 'Antofagasta', 3),
(null,'CL', 'Atacama', 4),
(null,'CL', 'Coquimbo', 5),
(null,'CL', 'Valparaíso', 6),
(null,'CL', 'Metropolitana de Santiago', 7),
(null,'CL', 'Libertador General Bernardo O’Higgins', 8),
(null,'CL', 'Maule', 9),
(null,'CL', 'Ñuble', 10),
(null,'CL', 'Biobío', 11),
(null,'CL', 'La Araucanía', 12),
(null,'CL', 'Los Ríos', 13),
(null,'CL', 'Los Lagos', 14),
(null,'CL', 'Aysén del General Carlos Ibáñez del Campo', 15),
(null,'CL', 'Magallanes y la Antártica Chilena', 16);

insert into ciudad (`ID_REGION`, `ID_CIUDAD`,`NOMBRE`,`ORDEN`) values
(7,null, 'Santiago', 1),
(7,null, 'Cerrillos', 2),
(7,null, 'Cerro Navia', 3),
(7,null, 'Conchalí', 4),
(7,null, 'El Bosque', 5),
(7,null, 'Estación Central', 6),
(7,null, 'Huechuraba', 7),
(7,null, 'Independencia', 8),
(7,null, 'La Cisterna', 8),
(7,null, 'La Florida', 10),
(7,null, 'La Granja', 11),
(7,null, 'La Pintana', 12),
(7,null, 'La Reina', 13),
(7,null, 'Las Condes', 14),
(7,null, 'Lo Barnechea', 15),
(7,null, 'Lo Espejo', 16),
(7,null, 'Lo Prado', 17),
(7,null, 'Macul', 18),
(7,null, 'Maipú', 19),
(7,null, 'Ñuñoa', 20),
(7,null, 'Pedro Aguirre Cerda', 21),
(7,null, 'Peñalolén', 22),
(7,null, 'Providencia', 23),
(7,null, 'Pudahuel', 24),
(7,null, 'Quilicura', 25),
(7,null, 'Quinta Normal', 26),
(7,null, 'Recoleta', 27),
(7,null, 'Renca', 28),
(7,null, 'San Joaquín', 29),
(7,null, 'San Miguel', 30),
(7,null, 'San Ramón', 31),
(7,null, 'Vitacura', 32),
(7,null, 'Puente Alto', 33),
(7,null, 'Pirque', 34),
(7,null, 'La Obra-Las Vertientes', 35),
(7,null, 'Valle Grande', 36),
(7,null, 'San Bernardo', 37),
(7,null, 'Padre Hurtado', 38),
(7,null, 'Ciudad del Valle', 39),
(7,null, 'San José de Maipo', 40),
(7,null, 'Colina', 41),
(7,null, 'Chicureo', 42),
(7,null, 'Chamisero', 43),
(7,null, 'Lampa', 44),
(7,null, 'Batuco', 45),
(7,null, 'Chicauma', 46),
(7,null, 'Tiltil', 47),
(7,null, 'Buin', 48),
(7,null, 'Alto Jahuel', 49),
(7,null, 'Bajos de San Agustín', 50),
(7,null, 'Paine', 51),
(7,null, 'Hospital', 52),
(7,null, 'Melipilla', 53),
(7,null, 'Curacaví', 54),
(7,null, 'Talagante', 55),
(7,null, 'El Monte', 56),
(7,null, 'Isla de Maipo', 57),
(7,null, 'La Islita', 58),
(7,null, 'Peñaflor', 59);



insert into carroceria (`ID_CARROCERIA`,`NOMBRE`,`DESCRIPCION`) values 
(null, 'Sedán', ''),
(null, 'SUV', ''),
(null, 'Coupé', ''),
(null, 'Furgón', ''),
(null, 'Convertible', ''),
(null, 'Hatchback', ''),
(null, 'Station Vagon', ''),
(null, 'Pik Up', '');



insert into marca (`ID_MARCA`,`NOMBRE`,`ID_PAIS`) values
(null,'BMW', null),
(null,'Chevrolet', null),
(null,'Ford', null),
(null,'Hyundai', null),
(null,'Kia', null),
(null,'Mazda', null),
(null,'Nissan', null),
(null,'Peugeot', null),
(null,'Suzuki', null),
(null,'Toyota', null);


/*
BMW">BMW</div>
Chevrolet">Chevrolet</div>
Ford">Ford</div>
Hyundai">Hyundai</div>
Kia">Kia</div>
Mazda">Mazda</div>
Nissan">Nissan</div>
Peugeot">Peugeot</div>
Suzuki">Suzuki</div>
Toyota">Toyota</div>
<hr>
<div class="dropdown-item" title="Abarth">Abarth</div>
<div class="dropdown-item" title="Alfa Romeo">Alfa Romeo</div>
<div class="dropdown-item" title="Amc">Amc</div>
<div class="dropdown-item" title="American Motors">American Motors</div>
<div class="dropdown-item" title="Asia">Asia</div>
<div class="dropdown-item" title="Aston Martin">Aston Martin</div>
<div class="dropdown-item" title="Audi">Audi</div>
<div class="dropdown-item" title="Austin">Austin</div>
<div class="dropdown-item" title="Austin Healey">Austin Healey</div>
<div class="dropdown-item" title="Autorrad">Autorrad</div>
<div class="dropdown-item" title="Baic">Baic</div>
<div class="dropdown-item" title="Bentley">Bentley</div>
<div class="dropdown-item" title="BMW">BMW</div>
<div class="dropdown-item" title="Brilliance">Brilliance</div>
<div class="dropdown-item" title="Buggy">Buggy</div>
<div class="dropdown-item" title="Buick">Buick</div>
<div class="dropdown-item" title="Byd">Byd</div>
<div class="dropdown-item" title="Cadillac">Cadillac</div>
<div class="dropdown-item" title="Can-Am">Can-Am</div>
<div class="dropdown-item" title="Changan">Changan</div>
<div class="dropdown-item" title="Chery">Chery</div>
<div class="dropdown-item" title="Chevrolet">Chevrolet</div>
<div class="dropdown-item" title="CHRYSLER">CHRYSLER</div>
<div class="dropdown-item" title="Citroã«N">Citroã«N</div>
<div class="dropdown-item" title="Citroën">Citroën</div>
<div class="dropdown-item" title="Daewoo">Daewoo</div>
<div class="dropdown-item" title="Daihatsu">Daihatsu</div>
<div class="dropdown-item" title="Datsun">Datsun</div>
<div class="dropdown-item" title="Dfm">Dfm</div>
<div class="dropdown-item" title="Dfsk">Dfsk</div>
<div class="dropdown-item" title="Dkw">Dkw</div>
<div class="dropdown-item" title="Dodge">Dodge</div>
<div class="dropdown-item" title="Dongfeng">Dongfeng</div>
<div class="dropdown-item" title="Ds">Ds</div>
<div class="dropdown-item" title="Faw">Faw</div>
<div class="dropdown-item" title="Ferrari">Ferrari</div>
<div class="dropdown-item" title="Fiat">Fiat</div>
<div class="dropdown-item" title="Ford">Ford</div>
<div class="dropdown-item" title="Foton">Foton</div>
<div class="dropdown-item" title="Freightliner">Freightliner</div>
<div class="dropdown-item" title="Gac Gonow">Gac Gonow</div>
<div class="dropdown-item" title="Gac Motor">Gac Motor</div>
<div class="dropdown-item" title="Geely">Geely</div>
<div class="dropdown-item" title="Gem">Gem</div>
<div class="dropdown-item" title="Gmc">Gmc</div>
<div class="dropdown-item" title="Great Wall">Great Wall</div>
<div class="dropdown-item" title="Hafei">Hafei</div>
<div class="dropdown-item" title="Haima">Haima</div>
<div class="dropdown-item" title="Haval">Haval</div><div class="dropdown-item" title="Honda">Honda</div><div class="dropdown-item" title="Huanghai - Sg">Huanghai - Sg</div><div class="dropdown-item" title="Hummer">Hummer</div><div class="dropdown-item" title="Hyundai">Hyundai</div><div class="dropdown-item" title="Ika">Ika</div><div class="dropdown-item" title="INFINITI">INFINITI</div><div class="dropdown-item" title="Iveco">Iveco</div><div class="dropdown-item" title="Jac">Jac</div><div class="dropdown-item" title="Jaguar">Jaguar</div><div class="dropdown-item" title="Jeep">Jeep</div><div class="dropdown-item" title="Jinbei">Jinbei</div><div class="dropdown-item" title="Jmc">Jmc</div><div class="dropdown-item" title="Kamaz">Kamaz</div><div class="dropdown-item" title="Kawasaki">Kawasaki</div><div class="dropdown-item" title="Kia">Kia</div><div class="dropdown-item" title="Kia Motors">Kia Motors</div><div class="dropdown-item" title="Ktm">Ktm</div><div class="dropdown-item" title="Kyc">Kyc</div><div class="dropdown-item" title="Lada">Lada</div><div class="dropdown-item" title="Lamborghini">Lamborghini</div><div class="dropdown-item" title="Lancia">Lancia</div><div class="dropdown-item" title="Land Rover">Land Rover</div><div class="dropdown-item" title="Landwind">Landwind</div><div class="dropdown-item" title="Lexus">Lexus</div><div class="dropdown-item" title="Lifan">Lifan</div><div class="dropdown-item" title="Lincoln">Lincoln</div><div class="dropdown-item" title="Mahindra">Mahindra</div><div class="dropdown-item" title="Maserati">Maserati</div><div class="dropdown-item" title="Maxus">Maxus</div><div class="dropdown-item" title="Mazda">Mazda</div><div class="dropdown-item" title="Mclaren">Mclaren</div><div class="dropdown-item" title="Mercedes-Benz">Mercedes-Benz</div><div class="dropdown-item" title="Mercury">Mercury</div><div class="dropdown-item" title="MG">MG</div><div class="dropdown-item" title="MINI">MINI</div><div class="dropdown-item" title="Mitsubishi">Mitsubishi</div><div class="dropdown-item" title="Morgan">Morgan</div><div class="dropdown-item" title="Morris">Morris</div><div class="dropdown-item" title="Motorrad">Motorrad</div><div class="dropdown-item" title="Nissan">Nissan</div><div class="dropdown-item" title="Oldsmobile">Oldsmobile</div><div class="dropdown-item" title="Opel">Opel</div><div class="dropdown-item" title="Otra Marca">Otra Marca</div><div class="dropdown-item" title="Peugeot">Peugeot</div><div class="dropdown-item" title="Plymouth">Plymouth</div><div class="dropdown-item" title="Polaris">Polaris</div><div class="dropdown-item" title="Pontiac">Pontiac</div><div class="dropdown-item" title="Porsche">Porsche</div><div class="dropdown-item" title="Proton">Proton</div><div class="dropdown-item" title="Ram">Ram</div><div class="dropdown-item" title="Range Rover">Range Rover</div><div class="dropdown-item" title="Regal Raptor">Regal Raptor</div><div class="dropdown-item" title="Renault">Renault</div><div class="dropdown-item" title="Rolls-Royce">Rolls-Royce</div><div class="dropdown-item" title="Rover">Rover</div><div class="dropdown-item" title="Saab">Saab</div><div class="dropdown-item" title="Samsung">Samsung</div><div class="dropdown-item" title="Scania">Scania</div><div class="dropdown-item" title="Seat">Seat</div><div class="dropdown-item" title="Shelby">Shelby</div><div class="dropdown-item" title="Simca">Simca</div><div class="dropdown-item" title="SKODA">SKODA</div><div class="dropdown-item" title="Sma">Sma</div><div class="dropdown-item" title="Smart">Smart</div><div class="dropdown-item" title="SsangYong">SsangYong</div><div class="dropdown-item" title="Subaru">Subaru</div><div class="dropdown-item" title="Suzuki">Suzuki</div><div class="dropdown-item" title="Tata">Tata</div><div class="dropdown-item" title="Toyota">Toyota</div><div class="dropdown-item" title="Triumph">Triumph</div><div class="dropdown-item" title="Volkswagen">Volkswagen</div><div class="dropdown-item" title="Volvo">Volvo</div><div class="dropdown-item" title="Willys">Willys</div><div class="dropdown-item" title="Zna">Zna</div><div class="dropdown-item" title="Zxauto">Zxauto</div></div>






<div class="dropdown-box">
<div class="dropdown-item" title="Modelo">Modelo</div>
<div class="dropdown-item" title="114">114</div>
<div class="dropdown-item" title="116">116</div>
<div class="dropdown-item" title="116I">116I</div>
<div class="dropdown-item" title="118">118</div>
<div class="dropdown-item" title="120">120</div>
<div class="dropdown-item hover" title="125">125</div>
<div class="dropdown-item" title="135">135</div>
<div class="dropdown-item" title="140">140</div>
<div class="dropdown-item" title="1602">1602</div>
<div class="dropdown-item" title="2002">2002</div>
<div class="dropdown-item" title="218">218</div>
<div class="dropdown-item" title="220">220</div>
<div class="dropdown-item" title="235">235</div>
<div class="dropdown-item" title="240I">240I</div>
<div class="dropdown-item" title="240M">240M</div>
<div class="dropdown-item" title="316">316</div>
<div class="dropdown-item" title="318">318</div>
<div class="dropdown-item" title="320">320</div>
<div class="dropdown-item" title="320I">320I</div>
<div class="dropdown-item" title="323">323</div>
<div class="dropdown-item" title="325">325</div>
<div class="dropdown-item" title="328">328</div>
<div class="dropdown-item" title="330">330</div>
<div class="dropdown-item" title="335">335</div>
<div class="dropdown-item" title="340">340</div>
<div class="dropdown-item" title="418">418</div>
<div class="dropdown-item" title="420">420</div>
<div class="dropdown-item" title="428">428</div>
<div class="dropdown-item" title="430">430</div>
<div class="dropdown-item" title="435">435</div>
<div class="dropdown-item" title="440">440</div>
<div class="dropdown-item" title="520">520</div>
<div class="dropdown-item" title="523">523</div>
<div class="dropdown-item" title="525">525</div>
<div class="dropdown-item" title="528">528</div>
<div class="dropdown-item" title="530">530</div>
<div class="dropdown-item" title="535">535</div>
<div class="dropdown-item" title="540">540</div>
<div class="dropdown-item" title="545">545</div>
<div class="dropdown-item" title="550">550</div>
<div class="dropdown-item" title="630">630</div>
<div class="dropdown-item" title="640">640</div>
<div class="dropdown-item" title="645">645</div>
<div class="dropdown-item" title="650">650</div>
<div class="dropdown-item" title="7 Activehybrid">7 Activehybrid</div>
<div class="dropdown-item" title="730">730</div>
<div class="dropdown-item" title="735">735</div>
<div class="dropdown-item" title="740">740</div>
<div class="dropdown-item" title="745">745</div>
<div class="dropdown-item" title="750">750</div>
<div class="dropdown-item" title="850">850</div>
<div class="dropdown-item" title="G310 R">G310 R</div>
<div class="dropdown-item" title="Gs 1200">Gs 1200</div>
<div class="dropdown-item" title="I3">I3</div>
<div class="dropdown-item" title="I8">I8</div>
<div class="dropdown-item" title="M2">M2</div>
<div class="dropdown-item" title="M3">M3</div>
<div class="dropdown-item" title="M4">M4</div>
<div class="dropdown-item" title="M5">M5</div>
<div class="dropdown-item" title="M550">M550</div>
<div class="dropdown-item" title="M6">M6</div>
<div class="dropdown-item" title="X1">X1</div>
<div class="dropdown-item" title="X2">X2</div>
<div class="dropdown-item" title="X3">X3</div>
<div class="dropdown-item" title="X4">X4</div>
<div class="dropdown-item" title="X5">X5</div>
<div class="dropdown-item" title="X6">X6</div>
<div class="dropdown-item" title="X7">X7</div>
<div class="dropdown-item" title="Z3">Z3</div>
<div class="dropdown-item" title="Z4">Z4</div>
</div>
*/


insert into modelo (
`ID_MODELO`,
`ID_MARCA`,
`ID_CARROCERIA`,
`NOMBRE`
) values
(null, 1, 1, '114'),
(null, 1, 1, '116'),
(null, 1, 1, '116I'),
(null, 1, 1, '118'),
(null, 1, 1, '120'),
(null, 1, 1, '125'),
(null, 1, 1, '135'),
(null, 1, 1, '140'),
(null, 1, 1, '1602'),
(null, 1, 1, '2002'),
(null, 1, 1, '218'),
(null, 1, 1, '220'),
(null, 1, 1, '235'),
(null, 1, 1, '240I'),
(null, 1, 1, '240M'),
(null, 1, 1, '316'),
(null, 1, 1, '318'),
(null, 1, 1, '320'),
(null, 1, 1, '320I'),
(null, 1, 1, '323'),
(null, 1, 1, '325'),
(null, 1, 1, '328'),
(null, 1, 1, '330'),
(null, 1, 1, '335'),
(null, 1, 1, '340'),
(null, 1, 1, '418'),
(null, 1, 1, '420'),
(null, 1, 1, '428'),
(null, 1, 1, '430'),
(null, 1, 1, '435'),
(null, 1, 1, '440'),
(null, 1, 1, '520'),
(null, 1, 1, '523'),
(null, 1, 1, '525'),
(null, 1, 1, '528'),
(null, 1, 1, '530'),
(null, 1, 1, '535'),
(null, 1, 1, '540'),
(null, 1, 1, '545'),
(null, 1, 1, '550'),
(null, 1, 1, '630'),
(null, 1, 1, '640'),
(null, 1, 1, '645'),
(null, 1, 1, '650'),
(null, 1, 1, 'Activehybrid'),
(null, 1, 1, '730'),
(null, 1, 1, '735'),
(null, 1, 1, '740'),
(null, 1, 1, '745'),
(null, 1, 1, '750'),
(null, 1, 1, '850'),
(null, 1, 1, 'G310 R'),
(null, 1, 1, 'Gs 1200'),
(null, 1, 1, 'I3'),
(null, 1, 1, 'I8'),
(null, 1, 1, 'M2'),
(null, 1, 1, 'M3'),
(null, 1, 1, 'M4'),
(null, 1, 1, 'M5'),
(null, 1, 1, 'M550'),
(null, 1, 1, 'M6'),
(null, 1, 1, 'X1'),
(null, 1, 1, 'X2'),
(null, 1, 1, 'X3'),
(null, 1, 1, 'X4'),
(null, 1, 1, 'X5'),
(null, 1, 1, 'X6'),
(null, 1, 1, 'X7'),
(null, 1, 1, 'Z3'),
(null, 1, 1, 'Z4');






insert into automotora (
`ID_AUTOMOTORA`,
`ID_MATRIZ`,
`ID_CIUDAD`,
`RUT`,
`NOMBRE`,
`EMAIL`,
`IMG`,
`URL`,
`DIRECCION`,
`HORARIO_LUN_VIE`,
`HORARIO_SAB`,
`HORARIO_DOM`,
`MAPA`,
`ESTADO`,
`FECHA_INGRESO`,
`FECHA_MODIFICACION`,
`SUBDOMINIO`,
`CONT_MINISITIO`,
`DESTACADA`,
`TELEFONO`,
`FAX`,
`RAZON_SOCIAL`               
) values
(
null, -- ID_AUTOMOTORA
1, -- ID_MATRIZ
1, -- ID_CIUDAD

'111111111', -- `RUT`                    
'SoloAutomotoras',--  `NOMBRE`                  
'contacto@SoloAutomotoras.cl', -- `EMAIL`           
'SoloAutomotoras.jpg', -- `IMG`     
'https://soloautomotoras.herokuapp.com/', -- `URL`    
'DIRECCION', -- `DIRECCION`           
'10:00 - 19:00', -- `HORARIO_LUN_VIE`       
'14:00 - 16:00', -- `HORARIO_SAB`           
'15:00 - 19:00', -- `HORARIO_DOM`           
'MAPA', -- `MAPA`                   
'activo', -- `ESTADO`               
now(), -- `FECHA_INGRESO`    
now(), -- `FECHA_MODIFICACION`    
'https://soloautomotoras.herokuapp.com/', -- `SUBDOMINIO`    
0, -- `CONT_MINISITIO`        
1, -- `DESTACADA`     
'', -- `TELEFONO`          
'', -- `FAX`                
'' -- `RAZON_SOCIAL`   
);




insert into vendedor (
`ID_AUTOMOTORA`,
`ID_VENDEDOR`,
`NOMBRE`,
`APELLIDO_PATERNO`,
`APELLIDO_MATERNO`,
`RUT`,
`EMAIL`,
`PASSWORD`,
`TELEFONO`,
`MOVIL`,
`DIRECCION`,
`FECHA_INGRESO`,
`FECHA_MODIFICACION`,
`TIPO`              
) values (
1, -- `ID_AUTOMOTORA`,
null, -- `ID_VENDEDOR`,
'Vendedor 1', -- `NOMBRE`,
'APELLIDO_PATERNO', -- `APELLIDO_PATERNO`,
'APELLIDO_MATERNO', -- `APELLIDO_MATERNO`,
'111111111', -- `RUT`,
'vendedor@ventas.cl', -- `EMAIL`,
'123qwe', -- `PASSWORD`,
'534535345', -- `TELEFONO`,
'5678769789', -- `MOVIL`,
'direccion', -- `DIRECCION`,
now(), -- `FECHA_INGRESO`,
now(), -- `FECHA_MODIFICACION`,
'vendedor' -- `TIPO`  
);



insert into atributo 
(`ID_ATRIBUTO`,`NOMBRE`           ,`TIPO`,`SECTOR`      ,`ESTADO`  ,`CONJUNTO`    ,`DESCRIPCION`) values 
(null         , 'Nuevo'           , 'sel', 'publicacion', 'activo' , 'etiqueta', 'Nuevo' ),
(null         , 'Oportunidad'     , 'sel', 'publicacion', 'activo' , 'etiqueta', 'Oportunidad' ),

(null         , 'Automática'      , 'sel', 'general', 'activo' , 'transmision', 'Automática' ),
(null         , 'Tiptronic'       , 'sel', 'general', 'activo' , 'transmision', 'Tiptronic' ),
(null         , 'Secuencial'      , 'sel', 'general', 'activo' , 'transmision', 'Secuencial' ),
(null         , 'Manual'          , 'sel', 'general', 'activo' , 'transmision', 'Manual' ),

(null         , 'Bencina'         , 'sel', 'general', 'activo' , 'combustible', 'Bencina' ),
(null         , 'Petroleo'        , 'sel', 'general', 'activo' , 'combustible', 'Petroleo' ),
(null         , 'Eléctrico'       , 'sel', 'general', 'activo' , 'combustible', 'Eléctrico' ),
(null         , 'Híbrido'         , 'sel', 'general', 'activo' , 'combustible', 'Híbrido' ),

(null         , 'Frenos ABS'      , 'sel', 'seguridad', 'activo'  , 'frenos'   , 'Frenos ABS' ),
(null         , 'Frenos Tambor'   , 'sel', 'seguridad', 'activo'  , 'frenos'   , 'Frenos Tambor' ),

(null         , 'Alza Vidrios Electricos', 'opt', 'equipo'   , 'activo'  , 'etiqueta'   , 'Alza Vidrios Electricos' ),
(null         , 'Climatizador'           , 'opt', 'equipo'   , 'activo'  , 'etiqueta'   , 'Climatizador' ),
(null         , 'Aire Acondicionado'     , 'opt', 'equipo'   , 'activo'  , 'etiqueta'   , 'Aire Acondicionado' );

