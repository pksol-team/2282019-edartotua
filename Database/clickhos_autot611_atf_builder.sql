-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2019 at 12:19 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clickhos_autot611_atf_builder`
--

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE `block` (
  `BLOCK_ID` int(10) UNSIGNED NOT NULL,
  `BLOCK_NAME` varchar(15) NOT NULL DEFAULT '',
  `BLOCK_DESCRIP` varchar(45) NOT NULL DEFAULT '',
  `ENTRY_RULE` tinyint(1) NOT NULL DEFAULT '0',
  `EXIT_RULE` tinyint(1) NOT NULL DEFAULT '0',
  `ORDER_MANAGEMENT` tinyint(1) NOT NULL DEFAULT '0',
  `MONEY_MANAGEMENT` tinyint(1) NOT NULL DEFAULT '0',
  `MT4_SOURCE_CODE` text,
  `MT4_EXTERNALS_PARAM` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `block`
--

INSERT INTO `block` (`BLOCK_ID`, `BLOCK_NAME`, `BLOCK_DESCRIP`, `ENTRY_RULE`, `EXIT_RULE`, `ORDER_MANAGEMENT`, `MONEY_MANAGEMENT`, `MT4_SOURCE_CODE`, `MT4_EXTERNALS_PARAM`) VALUES
(1, 'CRUCE_MM', 'Cruce Medias Móviles', 1, 1, 0, 0, 'bool ValidaCruceMM(int tipo)\r\n{\r\n\r\n   int mma=iMA(Symbol(),0,PERIOD_MM_A,0,TYPE_MM_A,PRICE_CLOSE,0);\r\n   int mmb=iMA(Symbol(),0,PERIOD_MM_A,0,TYPE_MM_A,PRICE_CLOSE,0);\r\n\r\n   int mma_ant=iMA(Symbol(),0,PERIOD_MM_A,0,TYPE_MM_A,PRICE_CLOSE,1);\r\n   int mmb_ant=iMA(Symbol(),0,PERIOD_MM_A,0,TYPE_MM_A,PRICE_CLOSE,1);\r\n\r\n   if(tipo==0 && mma>mmb && mma_ant<=mmb_ant) return true;\r\n   if(tipo==1 && mma<mmb && mma_ant>=mmb_ant) return true;   \r\n\r\n   return false;\r\n}', 'extern int #PERIOD_MM_A# = @PERIOD_MM_A@;\r\nextern ENUM_MA_METHOD #TYPE_MM_A# = @TYPE_MM_A@;\r\nextern int #PERIOD_MM_B# = @PERIOD_MM_B@;\r\nextern ENUM_MA_METHOD #TYPE_MM_B# = @TYPE_MM_B@;'),
(2, 'TAKE_PROFIT', 'Take Profit', 0, 1, 0, 0, 'printf(\"Hello builder\");\r\nprintf(\"all the code here...\");', ''),
(3, 'STOP_LOSS', 'Stop Loss', 0, 1, 0, 0, 'void AsignaSL(int tipo, int ticket)\r\n{\r\n\r\n\r\n\r\n  if(OrderSelect(ticket, SELECT_BY_TICKET)==true)\r\n  {\r\n\r\n     double sl;\r\n     \r\n     if(tipo==0) sl=NormalizeDouble(OrderOpenPrice()-PIPS_SL*Point());\r\n     if(tipo==1) sl=NormalizeDouble(OrderOpenPrice()+PIPS_SL*Point());\r\n\r\n     bool ok=OrderModify(ticket,OrderOpenPrice(),sl,OrderTakeProfit(),0,clrNONE);\r\n     if(!ok)\r\n     {\r\n         Alert(\"Error al asignar el SL a la orden con ticket: \"+ticket);\r\n     }\r\n  }\r\n}', 'extern int #SL_PIPS# = @SL_PIPS@;'),
(4, 'BREAK_EVEN', 'Break Even', 0, 0, 1, 0, '<placeholder>', ''),
(5, 'LOTE_INI', 'Lotaje Inicial', 0, 0, 0, 1, '<placeholder>', '');

-- --------------------------------------------------------

--
-- Table structure for table `cola_compilacion`
--

CREATE TABLE `cola_compilacion` (
  `ID` int(11) NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Codigo` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `cola_compilacion`
--

INSERT INTO `cola_compilacion` (`ID`, `Fecha`, `Codigo`) VALUES
(1, '2018-11-07 21:52:54', '#property strict\nconst int VELA=1; //0 (al tick) o 1 (a la vela)\n\nbool condicionesDeSalida(){return false;  }\nvoid cerrarTodo()  {  }\nint OnInit(){   Alert(\"SUCCESS\");return(INIT_SUCCEEDED);}\nvoid OnDeinit(const int reason) {}\nvoid OnTick()  {  }'),
(2, '2018-11-07 21:52:54', '#property strict\nconst int VELA=1; //0 (al tick) o 1 (a la vela)\n\nbool condicionesDeSalida(){return false;  }\nvoid cerrarTodo()  {  }\nint OnInit(){   Alert(\"SUCCESS\");return(INIT_SUCCEEDED);}\nvoid OnDeinit(const int reason) {}\nvoid OnTick()  {  }'),
(3, '2018-11-07 21:52:54', '#property strict\nconst int VELA=1; //0 (al tick) o 1 (a la vela)\n\nbool condicionesDeSalida(){return false;  }\nvoid cerrarTodo()  {  }\nint OnInit(){   Alert(\"SUCCESS\");return(INIT_SUCCEEDED);}\nvoid OnDeinit(const int reason) {}\nvoid OnTick()  {  }'),
(4, '2018-11-07 22:14:47', '#property strict\nconst int VELA=1; //0 (al tick) o 1 (a la vela)\n\nbool condicionesDeSalida(){return false;  }\nvoid cerrarTodo()  {  }\nint OnInit(){   Alert(\"SUCCESS\");return(INIT_SUCCEEDED);}\nvoid OnDeinit(const int reason) {}\nvoid OnTick()  {  }');

-- --------------------------------------------------------

--
-- Table structure for table `elements`
--

CREATE TABLE `elements` (
  `ELEMENT_ID` int(10) UNSIGNED NOT NULL,
  `ELEMENT_GROUP_ID` varchar(45) NOT NULL DEFAULT '',
  `ELEMENT_NAME` varchar(45) NOT NULL DEFAULT '',
  `IMAGE_URL` varchar(200) NOT NULL DEFAULT '',
  `SOURCE_CODE` text NOT NULL,
  `ORDER_ID` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `ACTIVE` tinyint(1) NOT NULL DEFAULT '0',
  `MORE_INFO_URL` varchar(200) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `elements`
--

INSERT INTO `elements` (`ELEMENT_ID`, `ELEMENT_GROUP_ID`, `ELEMENT_NAME`, `IMAGE_URL`, `SOURCE_CODE`, `ORDER_ID`, `ACTIVE`, `MORE_INFO_URL`) VALUES
(1, '1', 'CROSS_MA', 'images/MA_cross.png', 'indicadores_basicos.mqh', 1, 1, '/cruce-de-medias/'),
(2, '1', 'RSI', 'images/RSI.png', '', 3, 1, '/rsi/'),
(3, '1', 'MACD', 'images/MACD.png', '', 4, 1, '/builder_wiki/MACD/'),
(4, '4', 'HOURLY_FILTER', 'images/time_filter.png', '', 1, 1, '/filtro-horario/'),
(5, '2', 'SPREAD_FILTER', 'images/spread.png', '', 5, 1, '/filtro-de-spread/'),
(7, '0', 'SEQ', 'images/seq.png', '', 1, 1, '/secuencia/'),
(8, '0', 'OPEN', 'images/open.png', '', 1, 1, '/accion-abrir/'),
(9, '0', 'MODIFY', 'images/modify.png', '', 1, 1, '/accion-modificar/'),
(10, '0', 'CLOSE', 'images/close.png', '', 1, 1, '/accion-cerrar/'),
(11, '3', 'PROFIT_PIPS', 'images/profit_pips.png', 'a', 6, 1, ''),
(12, '3', 'LOSS_PIPS', 'images/loss_pips.png', 'a', 5, 1, ''),
(23, '1', 'CROSS_1MA', 'images/cruce1media.png', 'a', 2, 1, '/builder_wiki/cross_1ma/'),
(24, '2', 'PIVOT_POINT', 'images/pivot_point.png', 'a', 4, 1, '/builder_wiki/pivot_point/'),
(25, '2', 'HIGH_LOW', 'images/high_low.png', 'a', 1, 1, '/max-y-min/'),
(26, '1', 'ADX', 'images/ADX.png', 'a', 5, 1, '/builder_wiki/ADX/'),
(27, '4', 'FIXED_HOUR', 'images/hora_fija.png', 'a', 8, 1, '/builder_wiki/horafija/'),
(28, '1', 'FDI', 'images/FDI.png', 'a', 10, 1, '/builder_wiki/FDI/'),
(29, '1', 'BIGBAR_ATR', 'images/BigBar_ATR.png', 'a', 11, 1, '/builder_wiki/BigBar_ATR/'),
(30, '2', 'ADR', 'images/ADR.png', 'a', 3, 1, '/builder_wiki/ADR/'),
(31, '2', 'Fractals', 'images/Fractals.png', 'a', 2, 1, '/fractals/'),
(32, '3', 'TP_PORCENT', 'images/TP_DIST.png', 'a', 4, 1, '/distancia-tp/'),
(33, '1', 'STOCH', 'images/stoch.PNG', 'a', 12, 1, '/stochastico/'),
(34, '1', 'BOLL', 'images/bollinguer.PNG', 'a', 6, 1, '/bollinguer/'),
(35, '1', 'CCI', 'images/cci.PNG', 'a', 9, 1, '/cci/'),
(36, '1', 'PSAR', 'images/PSAR.PNG', 'a', 7, 1, '/parabolic-sar/'),
(37, '1', 'WILLIAMS', 'images/williams.PNG', 'a', 8, 1, '/williams/'),
(39, '3', 'SL_PORCENT', 'images/SL_DIST.PNG', 'a', 3, 1, '/distancia-sl/'),
(40, '3', 'LOSS_TOTAL', 'images/loss_total.PNG', 'a', 7, 1, '/perdida-acumulada/'),
(41, '3', 'PROFIT_TOTAL', 'images/profit_total.PNG', 'a', 8, 1, '/beneficio-acumulado/'),
(42, '3', 'COUNT_ORD', 'images/count_order.PNG', 'a', 9, 1, '/cuenta-ordenes/'),
(43, '4', 'DAILY_FILTER', 'images/daily_calendar.PNG', 'a', 23, 1, '/calendario-diario/'),
(44, '4', 'AFTER_X_TIME', 'images/after_x_time.PNG', 'a', 24, 1, '/pasado-tiempo-x/'),
(45, '4', 'EVERY_X_TIME', 'images/every_x_time.PNG', 'a', 25, 0, '/cada-x-tiempo/'),
(46, '4', 'OPEN_CONFIG', 'images/config.PNG', 'a', 26, 1, '/configurar-abrir/'),
(47, '4', 'MODIFY_CONFIG', 'images/config.PNG', 'a', 27, 1, '/configurar-modificar/'),
(48, '4', 'CLOSE_CONFIG', 'images/config.PNG', 'a', 28, 1, '/configurar-cerrar/'),
(49, '3', 'REVERSE_SIGNAL', 'images/reverse_signal.PNG', 'a', 10, 1, '/senal-inversal/'),
(50, '3', 'DIST_TP', 'images/dist_tp.PNG', 'a', 2, 1, '/distancia-tp/'),
(51, '3', 'DIST_SL', 'images/dist_sl.PNG', 'a', 1, 1, '/distancia-sl/');

-- --------------------------------------------------------

--
-- Table structure for table `element_group`
--

CREATE TABLE `element_group` (
  `GROUP_ID` int(10) UNSIGNED NOT NULL,
  `GROUP_NAME` varchar(45) NOT NULL DEFAULT '',
  `ORDER_ID` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `ACTIVE` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `element_group`
--

INSERT INTO `element_group` (`GROUP_ID`, `GROUP_NAME`, `ORDER_ID`, `ACTIVE`) VALUES
(1, 'INDICATORS', 1, 1),
(2, 'LEVELS', 2, 1),
(3, 'ORDERS', 3, 1),
(4, 'GROUP4', 4, 1),
(5, 'GROUP5_NOACTIVE', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `error`
--

CREATE TABLE `error` (
  `ERROR_CODE` int(10) UNSIGNED NOT NULL,
  `ERROR_DESC` varchar(300) NOT NULL DEFAULT '',
  `LANG_ID` varchar(2) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `error`
--

INSERT INTO `error` (`ERROR_CODE`, `ERROR_DESC`, `LANG_ID`) VALUES
(0, 'Please, add at least one element.', 'EN'),
(0, 'Por favor, añade al menos un elemento.', 'ES'),
(1, 'There is one or more sequencies as a first element, please change order or remove it.', 'EN'),
(1, 'Hay una o más secuencias como primer elemento, por favor cambia el orden o elimínala.', 'ES'),
(2, 'There is one or more sequencies as a last element, please change order or remove it.', 'EN'),
(2, 'Hay una o más secuencias como último elemento, por favor cambia el orden o elimínala.', 'ES'),
(3, 'There is more than 1 sequences together, please leave only 1 sequence between elements.', 'EN'),
(3, 'Hay más de una secuencias juntas, por favor, deja solamente 1 secuencia entre elementos.', 'ES');

-- --------------------------------------------------------

--
-- Table structure for table `languajes`
--

CREATE TABLE `languajes` (
  `LANGUAJE_ID` varchar(2) NOT NULL DEFAULT '',
  `LANG_NAME` varchar(45) NOT NULL DEFAULT '',
  `DEFAULT` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `languajes`
--

INSERT INTO `languajes` (`LANGUAJE_ID`, `LANG_NAME`, `DEFAULT`) VALUES
('EN', 'English', 0),
('ES', 'Español', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE `parameters` (
  `PARAM_ID` int(10) UNSIGNED NOT NULL,
  `PARAM_NAME` varchar(15) NOT NULL DEFAULT '',
  `PARAM_TYPE` varchar(200) NOT NULL DEFAULT '',
  `DEFAULT_PARAM` varchar(45) NOT NULL DEFAULT '0',
  `ELEMENT_ID` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `ORDER_ID` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `ACTIVE` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `parameters`
--

INSERT INTO `parameters` (`PARAM_ID`, `PARAM_NAME`, `PARAM_TYPE`, `DEFAULT_PARAM`, `ELEMENT_ID`, `ORDER_ID`, `ACTIVE`) VALUES
(1, 'PERIOD_MM_A', 'INTEGER', '50', 1, 1, 1),
(2, 'PERIOD_MM_B', 'INTEGER', '200', 1, 2, 1),
(3, 'TYPE_MM', 'SIMPLE;EXPONENCIAL;SMOTHED;LINEAL_WEIGHTED', 'SIMPLE', 1, 3, 1),
(4, 'RSI_PERIOD', 'INTEGER', '14', 2, 1, 1),
(7, 'CLOSE_REVERSAL', 'BOOL', '1', 8, 9, 0),
(8, 'PRICE_REFERENCE', 'Precio Mercado;Precio Apertura Orden', 'Precio Mercado', 9, 2, 1),
(9, 'REVERSE_SIGNAL', 'BOOL', '1', 7, 1, 1),
(18, 'PIPS_NUM', 'INTEGER', '50', 11, 1, 1),
(19, 'PIPS_NUM', 'INTEGER', '50', 12, 1, 1),
(20, 'TYPE_PP', 'CRUCE;REBOTE', 'NORMAL', 24, 1, 0),
(21, 'ENABLE_TIME', 'BOOL', '1', 4, 1, 0),
(22, 'HOUR_START', 'STRING', '08:00', 4, 1, 1),
(23, 'HOUR_FINISH', 'STRING', '10:00', 4, 2, 1),
(24, 'ENABLE_TIME2', 'BOOL', '1', 4, 4, 0),
(25, 'HOUR_START2', 'STRING', '15:00', 4, 5, 0),
(26, 'HOUR_FINISH2', 'STRING', '17:00', 4, 6, 0),
(27, 'ENABLE_TIME3', 'BOOL', '0', 4, 7, 0),
(28, 'HOUR_START3', 'STRING', '21:00', 4, 8, 0),
(29, 'HOUR_FINISH3', 'STRING', '23:00', 4, 9, 0),
(30, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 24, 1, 1),
(31, 'SUPP_FOR', 'Compras;Ventas;Compras y Ventas', 'Compras', 24, 2, 1),
(32, 'RESIST_FOR', 'Compras;Ventas;Compras y Ventas', 'Ventas', 24, 3, 1),
(33, 'PROFIT_WHEN', 'Nada;Nivel Siguiente', 'Nivel Siguiente', 24, 5, 0),
(34, 'STOP_WHEN', 'Nada;Nivel Anterior', 'Nivel Anterior', 24, 6, 0),
(35, 'NUM_CANDLES', 'INTEGER', '1', 25, 1, 1),
(36, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 25, 2, 1),
(37, 'LOW_HL', 'Compras;Ventas;Compras y Ventas', 'Compras', 25, 3, 1),
(38, 'HIGH_HL', 'Compras;Ventas;Compras y Ventas', 'Ventas', 25, 4, 1),
(39, 'PIPS_MARGIN', 'INTEGER', '10', 25, 5, 1),
(41, 'PIPS_SPREAD', 'INTEGER', '15', 5, 1, 1),
(43, 'MULTI_ORDER', 'BOOL', '0', 8, 10, 0),
(44, 'VOLUMEN', 'DOUBLE', '1.00', 8, 1, 1),
(45, 'BUY', 'BOOL', '1', 8, 2, 0),
(46, 'SELL', 'BOOL', '1', 8, 3, 0),
(47, 'ALERT_MT4', 'BOOL', '1', 8, 4, 1),
(48, 'ALERT', 'STRING', 'Apertura de orden', 8, 7, 1),
(49, 'STOP_LOSS', 'INTEGER', '0', 8, 2, 1),
(50, 'SL_TP', 'Stop Loss;Take Profit', 'Stop Loss', 9, 1, 1),
(51, 'CUANTITY', 'INTEGER', '10', 9, 3, 1),
(55, 'ALERT_MT4', 'BOOL', '1', 9, 4, 1),
(56, 'ALERT', 'STRING', 'Modificación de orden', 9, 7, 1),
(59, 'QUANTITY_CLOSE', 'DOUBLE', '100', 10, 1, 1),
(62, 'ALERT_MT4', 'BOOL', '1', 10, 2, 1),
(63, 'ALERT', 'STRING', 'Cierre de orden', 10, 5, 1),
(64, 'TAKE_PROFIT', 'INTEGER', '0', 8, 3, 1),
(65, 'ACT_WHEN', 'TICK;CIERRE VELA', 'CIERRE VELA', 24, 7, 0),
(73, 'PORC_TP', 'INTEGER', '50', 32, 1, 1),
(75, 'SOBRECOMP', 'INTEGER', '70', 2, 2, 1),
(76, 'SOBREVENT', 'INTEGER', '30', 2, 3, 1),
(77, 'TIPO_SIGNAL_RSI', 'Entrar en sobrecompra/sobreventa;Salir de sobrecompra/sobreventa', 'Salir de Extremos', 2, 4, 1),
(78, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 2, 7, 1),
(79, 'MM_CROSS_UP_MA', 'Compras;Ventas', 'Compras', 1, 6, 1),
(80, 'MM_CROSS_DOWN_M', 'Compras;Ventas', 'Ventas', 1, 7, 1),
(81, 'SHOOT_SIGNAL', 'Disparo;Filtro', 'Disparo', 1, 5, 1),
(82, 'PERIOD_MM_A', 'INTEGER', '50', 23, 1, 1),
(84, 'TYPE_MM', 'SIMPLE;EXPONENCIAL;SMOTHED;LINEAL_WEIGHTED', 'SIMPLE', 23, 2, 1),
(85, 'MM_CROSS_UP_1MA', 'Compras;Ventas', 'Compras', 23, 4, 1),
(86, 'MM_CROSS_DOWN_1', 'Compras;Ventas', 'Ventas', 23, 5, 1),
(87, 'SHOOT_SIGNAL', 'Disparo;Filtro', 'Disparo', 23, 6, 1),
(88, 'PORC_SL', 'INTEGER', '50', 39, 1, 1),
(89, 'DIST_PIPS_TP', 'INTEGER', '10', 50, 1, 1),
(90, 'DIST_PIPS_SL', 'INTEGER', '10', 51, 1, 1),
(91, 'LOSS_TARGET', 'DOUBLE', '500.00', 40, 1, 1),
(92, 'PROFIT_TARGET', 'DOUBLE', '500.00', 41, 1, 1),
(93, 'NUM_ORD', 'INTEGER', '5', 42, 1, 1),
(94, 'MORE_LESS', 'Igual o mayor;Menor', 'Igual o Mayor', 42, 2, 1),
(95, 'TYPE_ORDER_COUN', 'Cualquier Orden;Compras;Ventas', 'Cualquier Orden', 42, 3, 1),
(96, 'TIME_TYPE', 'Segundos;Minutos;Horas;Dias', 'Minutos', 44, 1, 1),
(97, 'TIME', 'INTEGER', '10', 44, 2, 1),
(100, 'ALLOW_BUYS', 'BOOL', '1', 46, 1, 1),
(101, 'ALLOW_SELLS', 'BOOL', '1', 46, 2, 1),
(102, 'ALLOW_ADIC_ORDE', 'BOOL', '1', 46, 5, 1),
(104, 'TYPE_READ', 'Tick;Cierre Vela;Temporizador', 'Cierre Vela', 46, 3, 1),
(105, 'SECONDS_READ', 'INTEGER', '9', 46, 4, 1),
(106, 'ALLOW_BUYS', 'BOOL', '1', 47, 1, 1),
(107, 'ALLOW_SELLS', 'BOOL', '1', 47, 2, 1),
(108, 'TYPE_READ', 'Tick;Cierre Vela;Temporizador', 'Cierre Vela', 47, 4, 1),
(109, 'SECONDS_READ', 'INTEGER', '7', 47, 5, 1),
(110, 'ALLOW_BUYS', 'BOOL', '1', 48, 1, 1),
(111, 'ALLOW_SELLS', 'BOOL', '1', 48, 2, 1),
(114, 'TYPE_READ', 'Tick;Cierre Vela;Temporizador', 'Cierre Vela', 48, 4, 1),
(115, 'SECONDS_READ', 'INTEGER', '6', 48, 5, 1),
(116, 'ALERT_MOVIL', 'BOOL', '1', 8, 5, 1),
(117, 'ALERT_MAIL', 'BOOL', '1', 8, 6, 1),
(118, 'ALERT_MOVIL', 'BOOL', '1', 9, 6, 1),
(120, 'ALERT_MAIL', 'BOOL', '1', 9, 5, 1),
(121, 'ALERT_MOVIL', 'BOOL', '1', 10, 3, 1),
(122, 'ALERT_MAIL', 'BOOL', '1', 10, 4, 1),
(123, 'ALLOW_D1', 'BOOL', '1', 43, 1, 1),
(124, 'ALLOW_D2', 'BOOL', '1', 43, 2, 1),
(125, 'ALLOW_D3', 'BOOL', '1', 43, 3, 1),
(126, 'ALLOW_D4', 'BOOL', '1', 43, 4, 1),
(127, 'ALLOW_D5', 'BOOL', '1', 43, 5, 1),
(128, 'ALLOW_D6', 'BOOL', '1', 43, 6, 1),
(129, 'ALLOW_D7', 'BOOL', '1', 43, 7, 1),
(130, 'HOUR', 'STRING', '16:30', 27, 7, 1),
(131, 'TYPE_CONT_FRACT', 'Velas;Fractales', 'Velas', 31, 1, 1),
(132, 'NUM_ULT', 'INTEGER', '10', 31, 2, 1),
(133, 'MAX_FOR', 'Compras;Ventas;Nada', 'Compras', 31, 3, 1),
(134, 'LOW_FOR', 'Compras;Ventas;Nada', 'Ventas', 31, 4, 1),
(135, 'ADR1', 'INTEGER', '5', 30, 1, 1),
(136, 'ADR2', 'INTEGER', '10', 30, 2, 1),
(137, 'ADR3', 'INTEGER', '20', 30, 3, 1),
(138, 'MAX_FOR', 'Compras;Ventas;Nada', 'Compras', 30, 4, 1),
(139, 'LOW_FOR', 'Compras;Ventas;Nada', 'Ventas', 30, 5, 1),
(140, 'SOBRECOMP_TYP', 'Compras;Ventas', 'Ventas', 2, 5, 1),
(141, 'SOBREVENT_TYP', 'Compras;Ventas', 'Compras', 2, 6, 1),
(142, 'SHOOT_SIGNAL', 'Filtro;Disparo', 'Filtro', 2, 8, 1),
(143, 'FAST_EMA', 'INTEGER', '12', 3, 1, 1),
(144, 'SLOW_EMA', 'INTEGER', '26', 3, 2, 1),
(145, 'MACD_SMA', 'INTEGER', '9', 3, 3, 1),
(146, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 3, 4, 1),
(147, 'CROSS_UP', 'Compras;Ventas', 'Compras', 3, 5, 1),
(148, 'CROSS_DOWN', 'Compras;Ventas', 'Ventas', 3, 6, 1),
(149, 'SHOOT_FILTER', 'Filtro;Disparo', 'Filtro', 3, 7, 1),
(150, 'ADX_PER', 'INTEGER', '14', 26, 1, 1),
(151, 'LEVEL_ADX', 'BOOL', '1', 26, 2, 1),
(152, 'LEVEL_ACT', 'DOUBLE', '25.00', 26, 3, 1),
(153, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 26, 4, 1),
(154, 'CROSS_UP', 'Compras;Ventas', 'Compras', 26, 5, 1),
(155, 'CROSS_DOWN', 'Compras;Ventas', 'Ventas', 26, 6, 1),
(156, 'SHOOT_SIGNAL', 'Filtro;Disparo', 'Filtro', 26, 7, 1),
(157, 'FDI_PER', 'INTEGER', '30', 28, 1, 1),
(158, 'FDI_LVL', 'DOUBLE', '1.5', 28, 2, 1),
(159, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 28, 3, 1),
(160, 'TIPO_SIGNAL_FDI', 'Por debajo;Por encima', 'Por debajo', 28, 4, 1),
(161, 'SHOOT_SIGNAL', 'Filtro;Disparo', 'Filtro', 28, 5, 1),
(162, 'ATR_PER', 'INTEGER', '14', 29, 1, 1),
(163, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 29, 2, 1),
(164, 'ATF_FACT', 'DOUBLE', '2.5', 29, 3, 1),
(165, 'SHOOT_SIGNAL', 'Filtro;Disparo', 'Filtro', 29, 4, 1),
(166, 'STOCH_K', 'INTEGER', '5', 33, 1, 1),
(167, 'STOCH_D', 'INTEGER', '3', 33, 2, 1),
(168, 'STOCH_SLOW', 'INTEGER', '3', 33, 3, 1),
(169, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 33, 4, 1),
(170, 'FILTER', 'BOOL', '1', 33, 5, 1),
(171, 'LEVEL_UP', 'INTEGER', '80', 33, 6, 1),
(172, 'LEVEL_DOWN', 'INTEGER', '20', 33, 7, 1),
(173, 'CROSS_UP', 'Compras;Ventas', 'Compras', 33, 8, 1),
(174, 'CROSS_DOWN', 'Compras;Ventas', 'Ventas', 33, 9, 1),
(175, 'SHOOT_SIGNAL', 'Filtro;Disparo', 'Filtro', 33, 10, 1),
(176, 'BOLL_PER', 'INTEGER', '20', 34, 1, 1),
(177, 'BOLL_DEV', 'DOUBLE', '2.00', 34, 2, 1),
(178, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 34, 3, 1),
(179, 'BOLL_ZONE', 'Cruzar fuera Bollinger;Cruzar dentro Bollinger', 'Cruzar dentro Bollinger', 34, 4, 1),
(180, 'BAND_UP', 'Compras;Ventas', 'Ventas', 34, 5, 1),
(181, 'BAND_DOWN', 'Compras;Ventas', 'Compras', 34, 6, 1),
(182, 'BAND_MID', 'Compras;Ventas;Compras y Ventas;Nada', 'Nada', 34, 7, 1),
(183, 'SHOOT_SIGNAL', 'Filtro;Disparo', 'Filtro', 34, 8, 1),
(184, 'CCI_PER', 'INTEGER', '20', 35, 1, 1),
(185, 'CCI_UP', 'INTEGER', '100', 35, 2, 1),
(186, 'CCI_DOWN', 'INTEGER', '-100', 35, 3, 1),
(187, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 35, 4, 1),
(188, 'CCI_ZONE', 'Entrar en Extremos;Salir de Extremos', 'Salir de Extremos', 35, 5, 1),
(189, 'UP_FOR', 'Compras;Ventas', 'Ventas', 35, 6, 1),
(190, 'DOWN_FOR', 'Compras;Ventas', 'Compras', 35, 7, 1),
(191, 'SHOOT_SIGNAL', 'Filtro;Disparo', 'Filtro', 35, 8, 1),
(192, 'PSAR_PASO', 'DOUBLE', '0.02', 36, 1, 1),
(193, 'PSAR_MAX', 'DOUBLE', '0.2', 36, 2, 1),
(194, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 36, 3, 1),
(195, 'PSAR_ABOVE', 'Compras;Ventas', 'Ventas', 36, 4, 1),
(196, 'PSAR_BELOW', 'Compras;Ventas', 'Compras', 36, 5, 1),
(197, 'SHOOT_SIGNAL', 'Filtro;Disparo', 'Filtro', 36, 6, 1),
(198, 'WILL_PER', 'INTEGER', '14', 37, 1, 1),
(199, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 37, 2, 1),
(200, 'WILL_LVL_UP', 'INTEGER', '-20', 37, 3, 1),
(201, 'WILL_LVL_DW', 'INTEGER', '-80', 37, 4, 1),
(202, 'WILL_DW', 'Compras;Ventas', 'Compras', 37, 5, 1),
(203, 'WILL_UP', 'Compras;Ventas', 'Ventas', 37, 6, 1),
(204, 'WILL_ZONE', 'Entrar en Extremos;Salir de Extremos', 'Salir de Extremos', 37, 7, 1),
(205, 'SHOOT_SIGNAL', 'Filtro;Disparo', 'Filtro', 37, 8, 1),
(206, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 1, 4, 1),
(207, 'TF', 'Actual;1 Min;5 Min;15 Min; 30 Min; 1 Hora; 4 Horas;1 Dia;1 semana; 1 Mes', 'Actual', 23, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_keys`
--

CREATE TABLE `payment_keys` (
  `id` int(11) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `seceret_key` varchar(255) NOT NULL,
  `publish_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_keys`
--

INSERT INTO `payment_keys` (`id`, `payment_type`, `seceret_key`, `publish_key`) VALUES
(1, 'stripe', 'sk_test_doaAddzso5GZH5xoQ4YwDbQO', 'pk_test_fu9pPdhwW3qilZxpvQ1UjF24');

-- --------------------------------------------------------

--
-- Table structure for table `session_compiled`
--

CREATE TABLE `session_compiled` (
  `session_comp_id` int(10) UNSIGNED NOT NULL,
  `session_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `url_file` varchar(45) NOT NULL DEFAULT '',
  `estatus` varchar(45) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session_compiled`
--

INSERT INTO `session_compiled` (`session_comp_id`, `session_id`, `user_id`, `url_file`, `estatus`) VALUES
(1, 18, 0, 'file', 'F'),
(2, 5, 53, 'ASDFAS', 'F'),
(3, 5, 53, 'TESTING', 'F'),
(4, 18, 0, '', 'N'),
(5, 18, 0, '', 'N'),
(6, 18, 0, '', 'N'),
(7, 18, 0, 'asdfasdf', 'F'),
(8, 18, 0, 'asdfasdf', 'F'),
(9, 18, 0, 'asdfasd', 'F'),
(10, 18, 58, 'TEST', 'F'),
(11, 18, 0, 'asdf', 'F'),
(12, 18, 0, '', 'N'),
(13, 18, 0, '', 'N'),
(14, 18, 0, 'asdfas', 'F'),
(15, 18, 0, 'ASDF', 'F'),
(16, 18, 0, 'ASDF', 'F'),
(17, 0, 0, '', 'N'),
(18, 18, 0, '', 'N'),
(19, 18, 0, '', 'N'),
(20, 18, 0, '', 'N'),
(21, 18, 0, '', 'N'),
(22, 18, 0, '', 'E'),
(23, 18, 0, '', 'E'),
(24, 18, 0, '', 'E'),
(25, 18, 0, '', 'E'),
(26, 18, 0, '', 'E'),
(27, 18, 0, '', 'E'),
(28, 18, 0, 'link', 'F'),
(29, 18, 0, 'ASDF', 'F'),
(30, 18, 0, 'asdf', 'F'),
(31, 18, 0, 'ASDF', 'F'),
(32, 18, 0, 'asdfasdfasdf', 'F'),
(33, 18, 0, 'ASDFASDF', 'F'),
(34, 18, 0, 'asdf', 'F'),
(35, 18, 0, 'ASDF', 'F'),
(36, 18, 0, 'asdfasd', 'F'),
(37, 18, 0, 'asdfasf', 'F'),
(38, 18, 0, '', 'E'),
(39, 18, 0, '', 'E'),
(40, 18, 0, '', 'E'),
(41, 18, 0, '', 'E'),
(42, 18, 0, '', 'E'),
(43, 18, 0, '', 'E'),
(44, 18, 0, '', 'E'),
(45, 18, 0, '', 'E'),
(46, 18, 0, '', 'E'),
(47, 18, 0, '', 'E'),
(48, 18, 0, '', 'E'),
(49, 18, 0, 'ASDFASDF', 'F'),
(50, 18, 0, '', 'E'),
(51, 18, 0, 'ASDFASDF', 'F'),
(52, 18, 0, '', 'N'),
(53, 18, 0, '', 'E'),
(54, 18, 0, '', 'E'),
(55, 18, 0, '', 'E'),
(56, 18, 0, 'ASDFASDF', 'F'),
(57, 18, 0, '', 'E'),
(58, 18, 0, 'ASDFS', 'F'),
(59, 18, 0, 'ASDF', 'F'),
(60, 18, 0, 'ASDF', 'F'),
(61, 18, 0, 'asdf', 'F'),
(62, 18, 0, 'ASDF', 'F'),
(63, 18, 0, 'ASDF', 'F'),
(64, 18, 0, 'ASDF', 'F'),
(65, 18, 0, 'ASDF', 'F'),
(66, 18, 0, 'asdf', 'F'),
(67, 18, 0, 'ASDF', 'F'),
(68, 18, 0, 'asdf', 'F'),
(69, 18, 0, 'ASDF', 'F'),
(70, 18, 0, '', 'E'),
(71, 18, 0, 'ASDF', 'F'),
(72, 18, 0, '', 'E'),
(73, 18, 0, 'asdfasdf', 'F'),
(74, 18, 0, 'asdf', 'F'),
(75, 18, 0, '', 'N'),
(76, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(77, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(78, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(79, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(80, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(81, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(82, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(83, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(84, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(85, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(86, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(87, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(88, 18, 0, 'ASDFASDF', 'F'),
(89, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(90, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(91, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(92, 15, 55, '', 'N'),
(93, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(94, 18, 0, '', 'N'),
(95, 18, 0, '', 'N'),
(96, 18, 0, '', 'N'),
(97, 18, 0, '', 'N'),
(98, 18, 0, '', 'N'),
(99, 18, 0, '', 'N'),
(100, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(101, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(102, 18, 0, 'tradeasy-0-85.ex4', 'F'),
(103, 18, 0, '', 'E');

-- --------------------------------------------------------

--
-- Table structure for table `session_payment`
--

CREATE TABLE `session_payment` (
  `session_pay_id` int(10) UNSIGNED NOT NULL,
  `session_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `type_payment` varchar(45) NOT NULL DEFAULT '',
  `estatus` char(1) NOT NULL DEFAULT '',
  `estatus_text` varchar(45) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session_payment`
--

INSERT INTO `session_payment` (`session_pay_id`, `session_id`, `user_id`, `type_payment`, `estatus`, `estatus_text`) VALUES
(1, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(2, 0, 0, 'STRIPE', 'F', ''),
(3, 18, 0, 'STRIPE', 'F', ''),
(4, 18, 0, 'STRIPE', 'F', 'Your card has insufficient funds.'),
(5, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(6, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(7, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(8, 18, 0, 'STRIPE', 'F', 'Your card has insufficient funds.'),
(9, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(10, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(11, 18, 0, 'STRIPE', 'F', 'Your card was declined.'),
(12, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(13, 18, 0, 'STRIPE', 'F', 'Your card was declined.'),
(14, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(15, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(16, 18, 0, 'STRIPE', 'F', 'Your card was declined.'),
(17, 18, 0, 'STRIPE', 'F', 'Your card was declined.'),
(18, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(19, 18, 0, 'STRIPE', 'F', 'Your card was declined.'),
(20, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(21, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(22, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(23, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(24, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(25, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(26, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(27, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(28, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(29, 18, 0, 'STRIPE', 'F', 'Your card has insufficient funds.'),
(30, 18, 0, 'STRIPE', 'F', 'Your card has insufficient funds.'),
(31, 18, 0, 'STRIPE', 'F', 'Your card has insufficient funds.'),
(32, 18, 0, 'STRIPE', 'F', 'Your card has insufficient funds.'),
(33, 18, 0, 'STRIPE', 'F', 'Your card has insufficient funds.'),
(34, 18, 0, 'STRIPE', 'F', 'Your card has insufficient funds.'),
(35, 18, 0, 'STRIPE', 'F', 'Your card has insufficient funds.'),
(36, 18, 0, 'STRIPE', 'F', 'Your card has insufficient funds.'),
(37, 18, 0, 'STRIPE', 'F', 'Your card has insufficient funds.'),
(38, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(39, 18, 0, 'STRIPE', 'F', 'Invalid positive integer'),
(40, 18, 0, 'STRIPE', 'F', 'Invalid positive integer'),
(41, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(42, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(43, 18, 0, 'STRIPE', 'F', 'Your card has insufficient funds.'),
(44, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(45, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(46, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(47, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(48, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull'),
(49, 18, 0, 'STRIPE', 'S', 'Payment transaction successfull');

-- --------------------------------------------------------

--
-- Table structure for table `session_strategy`
--

CREATE TABLE `session_strategy` (
  `sesion_id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(45) NOT NULL DEFAULT '',
  `open_scenario` text,
  `close_scenario` text,
  `modify_scenario` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `session_strategy`
--

INSERT INTO `session_strategy` (`sesion_id`, `user_id`, `open_scenario`, `close_scenario`, `modify_scenario`) VALUES
(1, 'admin', '1,50,200,2;2,14,70,30,5,0.1,1', '1,50,200,2;6,0', NULL),
(14, '56', '1,50,200,SIMPLE,1.0505,FURQAN;1,50,200,SIMPLE,1.0577,adfjkl;8,1;', '', ''),
(15, '55', '', '', '1,50,200,SIMPLE;9,Absoluto,Stop Loss,10,1,1,0,Modificación de orden,Orden de la CondiciÃ³n;'),
(16, '7', '2,14,70,30,Dentro sobrecompra/venta,Actual;undefined,1;undefined,1;2,14,70,30,Dentro sobrecompra/venta,Actual;8,1.00,1,1,0,Apertura de orden,0,0,1,0;', '', ''),
(17, '27', '3,50;8,1;', '', ''),
(18, '0', '1,;8,1.00,1,1,0,Apertura de orden,0,0,1,0;', '', ''),
(19, '21', '1,50,200,SIMPLE;8,1.00,1,1,0,Apertura de orden,0,0,1,0;', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `session_strategy_definition`
--

CREATE TABLE `session_strategy_definition` (
  `session_strat_def_id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(45) NOT NULL DEFAULT '',
  `definition_text` text NOT NULL,
  `sesion_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `estatus` varchar(45) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session_strategy_definition`
--

INSERT INTO `session_strategy_definition` (`session_strat_def_id`, `user_id`, `definition_text`, `sesion_id`, `estatus`) VALUES
(54, '7', '', 16, 'F'),
(62, '55', '', 15, 'F'),
(63, '21', '', 19, 'F'),
(64, '0', 'TEST', 18, 'N'),
(66, '7', '', 16, 'F');

-- --------------------------------------------------------

--
-- Table structure for table `session_validation`
--

CREATE TABLE `session_validation` (
  `session_validation_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `session_strategy_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `ticker_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `timeframe_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `start_time` varchar(255) NOT NULL DEFAULT '0000-00-00',
  `end_time` varchar(255) NOT NULL DEFAULT '0000-00-00',
  `result_report` text,
  `estatus` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session_validation`
--

INSERT INTO `session_validation` (`session_validation_id`, `user_id`, `session_strategy_id`, `ticker_id`, `timeframe_id`, `start_time`, `end_time`, `result_report`, `estatus`) VALUES
(221, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(222, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(223, 21, 19, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(224, 21, 19, 0, 2, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(225, 21, 19, 0, 3, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(226, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(227, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(228, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(229, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(230, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(231, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(232, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(233, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(234, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(235, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(236, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(237, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(238, 7, 16, 0, 1, '01/01/2019', '07/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(239, 7, 16, 0, 1, '01/01/2019', '07/03/2019', NULL, 'F'),
(240, 55, 15, 0, 1, '01/01/2019', '07/03/2019', NULL, 'F'),
(241, 55, 15, 0, 1, '01/01/2019', '07/03/2019', NULL, 'F'),
(242, 21, 19, 0, 1, '01/01/2019', '08/03/2019', NULL, 'F'),
(243, 21, 19, 0, 1, '01/01/2019', '08/03/2019', NULL, 'F'),
(244, 21, 19, 0, 1, '01/01/2019', '08/03/2019', NULL, 'F'),
(245, 55, 1, 0, 5, '01/01/2019', '08/03/2019', NULL, 'F'),
(246, 55, 15, 0, 1, '01/01/2019', '08/03/2019', NULL, 'F'),
(247, 7, 16, 0, 1, '01/01/2019', '11/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(248, 7, 16, 0, 1, '01/01/2019', '11/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(249, 7, 16, 0, 1, '01/01/2019', '11/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(250, 7, 16, 0, 1, '01/01/2019', '11/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(251, 7, 16, 0, 1, '01/01/2019', '11/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(252, 7, 16, 0, 1, '01/01/2019', '11/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(253, 7, 16, 0, 1, '01/01/2019', '11/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(254, 7, 16, 0, 1, '01/01/2019', '11/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(255, 21, 19, 0, 1, '01/01/2019', '11/03/2019', NULL, 'P'),
(256, 21, 19, 0, 1, '01/01/2019', '12/03/2019', NULL, 'P'),
(257, 21, 19, 0, 1, '01/01/2019', '12/03/2019', NULL, 'P'),
(258, 21, 19, 0, 1, '01/01/2019', '12/03/2019', NULL, 'P'),
(259, 21, 19, 0, 1, '01/01/2019', '12/03/2019', NULL, 'P'),
(260, 21, 19, 0, 1, '01/01/2019', '12/03/2019', NULL, 'P'),
(261, 21, 19, 0, 1, '01/01/2019', '12/03/2019', NULL, 'P'),
(262, 21, 19, 0, 1, '01/01/2019', '12/03/2019', NULL, 'P'),
(263, 21, 19, 0, 1, '01/01/2019', '12/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(264, 21, 19, 0, 1, '01/01/2019', '12/03/2019', 'Numero transacciones: 53; Rentabilidad: 0,16%; Drawdown: 0,5%', 'F'),
(265, 0, 18, 0, 1, '01/01/2019', '14/03/2019', NULL, 'N'),
(266, 0, 18, 0, 1, '01/01/2019', '01/04/2019', 'test', 'F'),
(267, 0, 18, 0, 1, '01/01/2019', '01/04/2019', NULL, 'P'),
(268, 0, 18, 0, 1, '01/01/2019', '01/04/2019', NULL, 'P'),
(269, 0, 18, 0, 1, '01/01/2019', '01/04/2019', NULL, 'P'),
(270, 0, 18, 0, 1, '01/01/2019', '01/04/2019', NULL, 'P'),
(271, 0, 18, 0, 1, '01/01/2019', '01/04/2019', NULL, 'P'),
(272, 0, 18, 0, 1, '01/01/2019', '01/04/2019', NULL, 'P'),
(273, 0, 18, 0, 1, '01/01/2019', '01/04/2019', 'TEST', 'F'),
(274, 0, 18, 0, 1, '01/01/2019', '01/04/2019', NULL, 'F'),
(275, 0, 18, 0, 1, '01/01/2019', '01/04/2019', NULL, 'N'),
(276, 0, 18, 0, 1, '01/01/2019', '01/04/2019', NULL, 'F'),
(277, 0, 18, 0, 1, '01/01/2019', '01/04/2019', 'test', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `session_validation_chart`
--

CREATE TABLE `session_validation_chart` (
  `chart_seq` int(10) UNSIGNED NOT NULL,
  `value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sesion_val_id` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session_validation_chart`
--

INSERT INTO `session_validation_chart` (`chart_seq`, `value`, `sesion_val_id`) VALUES
(1, '9982.40', 232),
(1, '9913.40', 263),
(1, '9913.40', 264),
(2, '9921.36', 232),
(2, '9921.86', 263),
(2, '9921.86', 264),
(3, '10058.69', 232),
(3, '10059.39', 263),
(3, '10059.39', 264),
(4, '10025.29', 232),
(4, '10026.19', 263),
(4, '10026.19', 264),
(5, '10018.09', 232),
(5, '10019.19', 263),
(5, '10019.19', 264),
(6, '10012.49', 232),
(6, '10013.69', 263),
(6, '10013.69', 264),
(7, '9992.79', 232),
(7, '9994.09', 263),
(7, '9994.09', 264),
(8, '9984.89', 232),
(8, '9986.29', 263),
(8, '9986.29', 264),
(9, '10023.01', 232),
(9, '10024.51', 263),
(9, '10024.51', 264),
(10, '9993.65', 232),
(10, '9995.35', 263),
(10, '9995.35', 264),
(11, '9989.45', 232),
(11, '9991.35', 263),
(11, '9991.35', 264),
(12, '10039.61', 232),
(12, '10041.61', 263),
(12, '10041.61', 264),
(13, '10019.81', 232),
(13, '10022.01', 263),
(13, '10022.01', 264),
(14, '10011.67', 232),
(14, '10014.07', 263),
(14, '10014.07', 264),
(15, '10079.26', 232),
(15, '10081.76', 263),
(15, '10081.76', 264),
(16, '10286.31', 232),
(16, '10289.01', 263),
(16, '10289.01', 264),
(17, '10416.03', 232),
(17, '10418.93', 263),
(17, '10418.93', 264),
(18, '10383.43', 232),
(18, '10386.53', 263),
(18, '10386.53', 264),
(19, '10355.88', 232),
(19, '10359.18', 263),
(19, '10359.18', 264),
(20, '10349.18', 232),
(20, '10352.58', 263),
(20, '10352.58', 264),
(21, '10346.38', 232),
(21, '10349.88', 263),
(21, '10349.88', 264),
(22, '10310.24', 232),
(22, '10313.84', 263),
(22, '10313.84', 264),
(23, '10281.14', 232),
(23, '10284.84', 263),
(23, '10284.84', 264),
(24, '10270.84', 232),
(24, '10274.64', 263),
(24, '10274.64', 264),
(25, '10260.34', 232),
(25, '10264.24', 263),
(25, '10264.24', 264),
(26, '10289.80', 232),
(26, '10293.80', 263),
(26, '10293.80', 264),
(27, '10351.93', 232),
(27, '10356.13', 263),
(27, '10356.13', 264),
(28, '10338.53', 232),
(28, '10342.93', 263),
(28, '10342.93', 264),
(29, '10324.13', 232),
(29, '10328.73', 263),
(29, '10328.73', 264),
(30, '10305.83', 232),
(30, '10310.53', 263),
(30, '10310.53', 264),
(31, '10285.43', 232),
(31, '10290.23', 263),
(31, '10290.23', 264),
(32, '10324.09', 232),
(32, '10328.99', 263),
(32, '10328.99', 264),
(33, '10312.69', 232),
(33, '10317.79', 263),
(33, '10317.79', 264),
(34, '10271.09', 232),
(34, '10276.39', 263),
(34, '10276.39', 264),
(35, '10263.89', 232),
(35, '10269.29', 263),
(35, '10269.29', 264),
(36, '10248.79', 232),
(36, '10254.29', 263),
(36, '10254.29', 264),
(37, '10236.89', 232),
(37, '10242.49', 263),
(37, '10242.49', 264),
(38, '10230.39', 232),
(38, '10236.09', 263),
(38, '10236.09', 264),
(39, '10225.29', 232),
(39, '10231.09', 263),
(39, '10231.09', 264),
(40, '10213.45', 232),
(40, '10219.35', 263),
(40, '10219.35', 264),
(41, '10200.45', 232),
(41, '10206.45', 263),
(41, '10206.45', 264),
(42, '10178.75', 232),
(42, '10184.85', 263),
(42, '10184.85', 264),
(43, '10094.88', 232),
(43, '10101.08', 263),
(43, '10101.08', 264),
(44, '10091.84', 232),
(44, '10098.14', 263),
(44, '10098.14', 264),
(45, '10075.04', 232),
(45, '10081.44', 263),
(45, '10081.44', 264),
(46, '10065.14', 232),
(46, '10071.64', 263),
(46, '10071.64', 264),
(47, '10079.46', 232),
(47, '10086.06', 263),
(47, '10086.06', 264),
(48, '10047.26', 232),
(48, '10054.06', 263),
(48, '10054.06', 264),
(49, '10202.55', 232),
(49, '10209.55', 263),
(49, '10209.55', 264),
(50, '10193.15', 232),
(50, '10200.35', 263),
(50, '10200.35', 264),
(51, '10166.35', 232),
(51, '10173.75', 263),
(51, '10173.75', 264),
(52, '10162.75', 232),
(52, '10170.25', 263),
(52, '10170.25', 264),
(53, '10154.95', 232),
(53, '10162.55', 263),
(53, '10162.55', 264),
(54, '9982.60', 263),
(55, '9982.60', 264),
(56, '1000.26', 266),
(57, '3000.26', 266),
(58, '1000.26', 267),
(59, '1330.56', 267),
(60, '1000.26', 268),
(61, '300.15', 268),
(62, '1000.26', 269),
(63, '1330.56', 269),
(64, '1000.26', 270),
(65, '1330.56', 270),
(66, '1000.26', 271),
(67, '1330.56', 271),
(68, '1000.26', 272),
(69, '1330.56', 272),
(70, '100.26', 272),
(71, '1930.56', 272);

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `id` int(10) UNSIGNED NOT NULL,
  `texto` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `temp`
--

INSERT INTO `temp` (`id`, `texto`) VALUES
(2, 'asdasdas');

-- --------------------------------------------------------

--
-- Table structure for table `ticker`
--

CREATE TABLE `ticker` (
  `TICKER_ID` int(10) UNSIGNED NOT NULL,
  `TICKER_NAME` varchar(45) NOT NULL DEFAULT '',
  `TICKER_GROUP` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ticker`
--

INSERT INTO `ticker` (`TICKER_ID`, `TICKER_NAME`, `TICKER_GROUP`) VALUES
(0, 'DOW JONES', 'INDEX'),
(1, 'EURUSD', 'FOREX'),
(2, 'GBPUSD', 'FOREX'),
(3, 'USDJPY', 'FOREX'),
(4, 'USDCAD', 'FOREX'),
(5, 'S&P500', 'INDEX'),
(7, 'NASDAQ', 'INDEX'),
(8, 'DAX', 'INDEX'),
(9, 'EUROSTOXX', 'INDEX'),
(10, 'IBEX35', 'INDEX'),
(11, 'GOLD', 'COMMODITY'),
(12, 'SILVER', 'COMMODITY'),
(13, 'CRUDE OIL', 'COMMODITY'),
(14, 'BTCUSD', 'CRYPTO');

-- --------------------------------------------------------

--
-- Table structure for table `timeframes`
--

CREATE TABLE `timeframes` (
  `TF_ID` int(10) UNSIGNED NOT NULL,
  `TF_NAME` varchar(45) NOT NULL DEFAULT '',
  `LANGUAJE_id` char(2) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `timeframes`
--

INSERT INTO `timeframes` (`TF_ID`, `TF_NAME`, `LANGUAJE_id`) VALUES
(1, '1 Minute', 'EN'),
(1, '1 Minuto', 'ES'),
(2, '5 Minutes', 'EN'),
(2, '5 Minutos', 'ES'),
(3, '15 Minutes', 'EN'),
(3, '15 Minutos', 'ES'),
(4, '30 Minutes', 'EN'),
(4, '30 Minutos', 'ES'),
(5, '1 Hour', 'EN'),
(5, '1 Hora', 'ES'),
(6, '4 Hour', 'EN'),
(6, '4 Horas', 'ES'),
(7, '1 Day', 'EN'),
(7, '1 Dia', 'ES'),
(8, '1 Week', 'EN'),
(8, '1 Semana', 'ES'),
(9, '1 Month', 'EN'),
(9, '1 Mes', 'ES');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `TRANS_ID` int(10) UNSIGNED NOT NULL,
  `TABLE_NAME` varchar(45) NOT NULL DEFAULT '',
  `CONCEPT_NAME` varchar(45) NOT NULL DEFAULT '',
  `REG_ID` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `TEXT` varchar(200) NOT NULL DEFAULT '',
  `LANG_ID` varchar(2) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`TRANS_ID`, `TABLE_NAME`, `CONCEPT_NAME`, `REG_ID`, `TEXT`, `LANG_ID`) VALUES
(1, 'ELEMENT_GROUP', 'GROUP_NAME', 1, 'Indicators', 'EN'),
(2, 'ELEMENT_GROUP', 'GROUP_NAME', 1, 'Indicadores', 'ES'),
(3, 'ELEMENT_GROUP', 'GROUP_DESCRIPTION', 1, 'Elements related with some technical indicator.', 'EN'),
(4, 'ELEMENT_GROUP', 'GROUP_DESCRIPTION', 1, 'Elementos relacionados con algún indicador técnico.', 'ES'),
(5, 'ELEMENTS', 'ELEMENT_NAME', 1, 'Moving Av. Cross', 'EN'),
(6, 'ELEMENTS', 'ELEMENT_NAME', 1, 'Cruce Medias', 'ES'),
(7, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 1, 'Elements to validate the entry/exit when a moving average cross appears on market.', 'EN'),
(8, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 1, 'Elemento que da señal basado en 2 medias móviles.', 'ES'),
(9, '(none)', 'STRATEGY_TEXT1', 0, 'Drag from here items you want to add to your strategy TEST', 'EN'),
(10, '(none)', 'STRATEGY_TEXT1', 0, 'Arrastrar desde aquí los items que quieras agregar a tu estrategia', 'ES'),
(11, '(none)', 'STRATEGY_OPEN', 0, 'OPEN', 'EN'),
(12, '(none)', 'STRATEGY_OPEN', 0, 'REGLAS ENTRADA', 'ES'),
(13, '(none)', 'STRATEGY_CLOSE', 0, 'CLOSE', 'EN'),
(14, '(none)', 'STRATEGY_CLOSE', 0, 'REGLAS SALIDA', 'ES'),
(15, '(none)', 'STRATEGY_MODIFY', 0, 'MODIFY', 'EN'),
(16, '(none)', 'STRATEGY_MODIFY', 0, 'REGLAS MODIFICAR', 'ES'),
(17, 'ELEMENT_GROUP', 'GROUP_NAME', 2, 'Levels', 'EN'),
(18, 'ELEMENT_GROUP', 'GROUP_NAME', 2, 'Niveles', 'ES'),
(19, 'ELEMENT_GROUP', 'GROUP_NAME', 3, 'Order Events', 'EN'),
(20, 'ELEMENT_GROUP', 'GROUP_NAME', 3, 'Eventos Orden', 'ES'),
(21, 'ELEMENT_GROUP', 'GROUP_NAME', 4, 'Time Events', 'EN'),
(22, 'ELEMENT_GROUP', 'GROUP_NAME', 4, 'Eventos Tiempo', 'ES'),
(27, 'ELEMENTS', 'ELEMENT_NAME', 2, 'Indicator RSI', 'EN'),
(28, 'ELEMENTS', 'ELEMENT_NAME', 2, 'Indicador RSI', 'ES'),
(29, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 2, 'Element based on RSI indicator, considering oversold and overbought levels.', 'EN'),
(30, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 2, 'Elemento basado en lectura del indicador RSI con los niveles de sobrecompra y sobreventa.', 'ES'),
(31, 'ELEMENTS', 'ELEMENT_NAME', 3, 'Indicator MACD', 'EN'),
(32, 'ELEMENTS', 'ELEMENT_NAME', 3, 'Indicador MACD', 'ES'),
(33, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 3, 'Element based on MACD indicator', 'EN'),
(34, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 3, 'Elemento basado en lectura del indicador MACD', 'ES'),
(35, 'ELEMENTS', 'ELEMENT_NAME', 4, 'Time Filter', 'EN'),
(36, 'ELEMENTS', 'ELEMENT_NAME', 4, 'Filtro Horario', 'ES'),
(37, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 4, 'Filter element, using start and end time', 'EN'),
(38, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 4, 'Elemento de filtro, usando hora inicio y hora fin', 'ES'),
(39, 'ELEMENTS', 'ELEMENT_NAME', 5, 'Spread Filter', 'EN'),
(40, 'ELEMENTS', 'ELEMENT_NAME', 5, 'Filtro de Spread', 'ES'),
(41, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 5, 'Filter element, using to allow only current spread below X pips.', 'EN'),
(42, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 5, 'Elemento de filtro, usado para permitir solamente spreads por debajo de  X pips.', 'ES'),
(43, 'ELEMENTS', 'ELEMENT_NAME', 6, 'Inactive Element', 'EN'),
(44, 'ELEMENTS', 'ELEMENT_NAME', 6, 'Elemento Inactivo', 'ES'),
(45, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 6, 'Elemento inactivo que no debe verse en frontend', 'ES'),
(46, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 6, 'Inactive element that souldn\'t been visible on frontend', 'EN'),
(47, 'PARAMETERS', 'PARAM_NAME', 1, 'Fast Moving Average', 'EN'),
(48, 'PARAMETERS', 'PARAM_NAME', 1, 'Media Móvil Rápida', 'ES'),
(49, 'PARAMETERS', 'PARAM_NAME', 2, 'Slow Moving Average', 'EN'),
(50, 'PARAMETERS', 'PARAM_NAME', 2, 'Media Móvil Lenta', 'ES'),
(51, 'PARAMETERS', 'PARAM_NAME', 3, 'Moving Average Type', 'EN'),
(52, 'PARAMETERS', 'PARAM_NAME', 3, 'Tipo de Media Móvil', 'ES'),
(53, 'PARAMETERS', 'PARAM_NAME', 4, 'Period RSI', 'EN'),
(54, 'PARAMETERS', 'PARAM_NAME', 4, 'Periodos RSI', 'ES'),
(57, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT2', 0, 'Add new stage TEST', 'EN'),
(58, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT2', 0, 'Añadir escenario', 'ES'),
(59, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT3', 0, 'See strategy summary TEST', 'EN'),
(60, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT3', 0, 'Ver resumen de mi estrategia', 'ES'),
(61, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT4', 0, 'Drag here TEST', 'EN'),
(62, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT4', 0, 'Arrastrar aquí', 'ES'),
(63, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT5', 0, 'Add sequence TEST', 'EN'),
(64, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT5', 0, 'Añadir secuencia', 'ES'),
(65, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT6', 0, 'Save TEST', 'EN'),
(66, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT6', 0, 'Guardar', 'ES'),
(67, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT7', 0, 'More Info', 'EN'),
(68, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT7', 0, 'Más info', 'ES'),
(70, 'ELEMENTS', 'ELEMENT_NAME', 7, 'Sequence', 'EN'),
(71, 'ELEMENTS', 'ELEMENT_NAME', 7, 'Secuencia', 'ES'),
(74, 'PARAMETERS', 'PARAM_NAME', 11, 'param_new', 'EN'),
(75, 'PARAMETERS', 'PARAM_NAME', 11, 'parametro nuevo', 'ES'),
(76, 'ELEMENTS', 'ELEMENT_NAME', 12, 'Loss Pips', 'EN'),
(77, 'ELEMENTS', 'ELEMENT_NAME', 13, 'element new 3', 'EN'),
(78, 'ELEMENTS', 'ELEMENT_NAME', 14, 'element new 4', 'EN'),
(79, 'ELEMENTS', 'ELEMENT_NAME', 15, 'element new 5', 'EN'),
(80, 'ELEMENTS', 'ELEMENT_NAME', 16, 'element new 6', 'EN'),
(81, 'ELEMENTS', 'ELEMENT_NAME', 17, 'element new 7', 'EN'),
(82, 'ELEMENTS', 'ELEMENT_NAME', 18, 'element new 8', 'EN'),
(83, 'ELEMENTS', 'ELEMENT_NAME', 19, 'element new 9', 'EN'),
(84, 'ELEMENTS', 'ELEMENT_NAME', 20, 'element new 10', 'EN'),
(85, 'ELEMENTS', 'ELEMENT_NAME', 21, 'element new 11', 'EN'),
(86, 'ELEMENTS', 'ELEMENT_NAME', 22, 'element new 12', 'EN'),
(87, 'ELEMENTS', 'ELEMENT_NAME', 23, 'element new 13', 'EN'),
(88, 'ELEMENTS', 'ELEMENT_NAME', 11, 'Profit Pips', 'EN'),
(89, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 11, 'element new 1 description', 'EN'),
(96, 'PARAMETERS', 'PARAM_NAME', 7, 'Close Order If Reverse Signal', 'EN'),
(97, 'PARAMETERS', 'PARAM_NAME', 7, 'Cerrar Orden Si Señal Inversa', 'ES'),
(98, 'PARAMETERS', 'PARAM_NAME', 8, 'Asign or displace', 'EN'),
(99, 'PARAMETERS', 'PARAM_NAME', 8, 'Asignación basada en:', 'ES'),
(104, 'PARAMETERS', 'PARAM_NAME', 12, 'param EN', 'EN'),
(105, 'PARAMETERS', 'PARAM_NAME', 13, 'param EN2', 'EN'),
(106, 'PARAMETERS', 'PARAM_NAME', 14, 'param EN3', 'EN'),
(107, 'PARAMETERS', 'PARAM_NAME', 15, 'param EN4', 'EN'),
(109, 'PARAMETERS', 'PARAM_NAME', 17, 'param string', 'EN'),
(110, '(SCREEN JUMPERS)', 'JUMPER_NEXT', 0, 'Next', 'EN'),
(111, '(SCREEN JUMPERS)', 'JUMPER_NEXT', 0, 'Siguiente', 'ES'),
(112, '(SCREEN JUMPERS)', 'JUMPER_PREV_TEXT', 0, 'Previous', 'EN'),
(113, '(SCREEN JUMPERS)', 'JUMPER_PREV_TEXT', 0, 'Anterior', 'ES'),
(114, '(SCREEN JUMPERS)', 'JUMPER_STRATEGY_TEXT', 0, 'Build', 'EN'),
(115, '(SCREEN JUMPERS)', 'JUMPER_STRATEGY_TEXT', 0, 'Crea', 'ES'),
(116, '(SCREEN JUMPERS)', 'JUMPER_VAL_TEXT', 0, 'Validate', 'EN'),
(117, '(SCREEN JUMPERS)', 'JUMPER_VAL_TEXT', 0, 'Valida', 'ES'),
(118, '(SCREEN JUMPERS)', 'JUMPER_DOWN_TEXT', 0, 'Download', 'EN'),
(119, '(SCREEN JUMPERS)', 'JUMPER_DOWN_TEXT', 0, 'Descarga', 'ES'),
(120, '(SCREEN VAL)', 'TICKER_TEXT', 0, 'Ticker', 'EN'),
(121, '(SCREEN VAL)', 'TICKER_TEXT', 0, 'Activo', 'ES'),
(122, '(SCREEN VAL)', 'TIMEFRAME_TEXT', 0, 'TimeFrame', 'EN'),
(123, '(SCREEN VAL)', 'TIMEFRAME_TEXT', 0, 'TimeFrame', 'ES'),
(124, '(SCREEN VAL)', 'START_TEXT', 0, 'Start Time', 'EN'),
(125, '(SCREEN VAL)', 'START_TEXT', 0, 'Hora Inicio', 'ES'),
(126, '(SCREEN VAL)', 'END_TEXT', 0, 'End Time', 'EN'),
(127, '(SCREEN VAL)', 'END_TEXT', 0, 'Hora Fin', 'ES'),
(128, '(SCREEN VAL)', 'VALIDATE_BUTTON_TEXT', 0, 'VALIDATE', 'EN'),
(129, '(SCREEN VAL)', 'VALIDATE_BUTTON_TEXT', 0, 'VALIDAR', 'ES'),
(130, '(SCREEN VAL)', 'DATEFORMAT_TEXT', 0, 'MM/DD/YYYY', 'EN'),
(131, '(SCREEN VAL)', 'DATEFORMAT_TEXT', 0, 'DD/MM/YYYY', 'ES'),
(132, '(SCREEN VAL)', 'WELCOME_TEXT', 0, 'Set filters and click on validate', 'EN'),
(133, '(SCREEN VAL)', 'WELCOME_TEXT', 0, 'Selecciona los filtros y haz click en validar', 'ES'),
(134, '(SCREEN VAL)', 'WAITING_TEXT', 0, 'Validation your strategy', 'EN'),
(135, '(SCREEN VAL)', 'WAITING_TEXT', 0, 'Validando su estrategia', 'ES'),
(136, 'PARAMETERS', 'PARAM_NAME', 18, 'Pips Number', 'EN'),
(137, 'PARAMETERS', 'PARAM_NAME', 18, 'Número de Pips', 'ES'),
(138, 'PARAMETERS', 'PARAM_NAME', 19, 'Pips Number', 'EN'),
(139, 'PARAMETERS', 'PARAM_NAME', 19, 'Número de Pips', 'ES'),
(140, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT8', 0, 'Do you have doubts? Take a look our quick guide', 'EN'),
(141, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT8', 0, '¿Tienes dudas? Consulta nuestra guía rápida aquí', 'ES'),
(142, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT9', 0, 'here', 'EN'),
(143, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT9', 0, 'aquí', 'ES'),
(144, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT9_URL', 0, 'https://test.autotradingfactory.com/guia-rapida-de-strategy-builder/', 'EN'),
(145, '(STRATEGY_SCREEN)', 'STRATEGY_TEXT9_URL', 0, 'https://test.autotradingfactory.com/guia-rapida-de-strategy-builder/', 'ES'),
(146, '(STRATEGY_SCREEN)', 'TEXT_ERROR', 0, 'Something went wrong. This is the problem:', 'EN'),
(147, '(STRATEGY_SCREEN)', 'TEXT_ERROR', 0, 'Algo ha ido mal. Este es el motivo:', 'ES'),
(148, 'ELEMENTS', 'ELEMENT_NAME', 23, 'Cross Price-MA', 'EN'),
(149, 'ELEMENTS', 'ELEMENT_NAME', 23, 'Cruce Precio-MM', 'ES'),
(150, 'ELEMENTS', 'ELEMENT_NAME', 24, 'Pivot Point', 'EN'),
(151, 'ELEMENTS', 'ELEMENT_NAME', 24, 'Pivot Point', 'ES'),
(152, 'ELEMENTS', 'ELEMENT_NAME', 25, 'High Low', 'EN'),
(153, 'ELEMENTS', 'ELEMENT_NAME', 25, 'Max y Min', 'ES'),
(154, 'ELEMENTS', 'ELEMENT_NAME', 26, 'ADX', 'EN'),
(155, 'ELEMENTS', 'ELEMENT_NAME', 26, 'ADX', 'ES'),
(156, 'ELEMENTS', 'ELEMENT_NAME', 27, 'Fixed Hour', 'EN'),
(157, 'ELEMENTS', 'ELEMENT_NAME', 27, 'Hora Fija', 'ES'),
(158, 'ELEMENTS', 'ELEMENT_NAME', 28, 'FDI', 'EN'),
(159, 'ELEMENTS', 'ELEMENT_NAME', 28, 'FDI', 'ES'),
(160, 'ELEMENTS', 'ELEMENT_NAME', 29, 'Big Bar ATR', 'EN'),
(161, 'ELEMENTS', 'ELEMENT_NAME', 29, 'Vela vs ATR', 'ES'),
(162, 'ELEMENTS', 'ELEMENT_NAME', 30, 'ADR', 'EN'),
(163, 'ELEMENTS', 'ELEMENT_NAME', 30, 'ADR', 'ES'),
(164, 'ELEMENTS', 'ELEMENT_NAME', 31, 'Fractals', 'EN'),
(165, 'ELEMENTS', 'ELEMENT_NAME', 31, 'Fractales', 'ES'),
(166, 'PARAMETERS', 'PARAM_NAME', 20, 'Signal type', 'EN'),
(167, 'PARAMETERS', 'PARAM_NAME', 20, 'Tipo de senal', 'ES'),
(168, 'PARAMETERS', 'PARAM_NAME', 21, 'Enable Time Filter 1', 'EN'),
(169, 'PARAMETERS', 'PARAM_NAME', 21, 'Activar Filtro Horario 1', 'ES'),
(170, 'PARAMETERS', 'PARAM_NAME', 22, 'Start Time 1', 'EN'),
(171, 'PARAMETERS', 'PARAM_NAME', 22, 'Hora Inicio:', 'ES'),
(172, 'PARAMETERS', 'PARAM_NAME', 23, 'End Time 1', 'EN'),
(173, 'PARAMETERS', 'PARAM_NAME', 23, 'Hora Fin:', 'ES'),
(174, 'PARAMETERS', 'PARAM_NAME', 24, 'Enable Time Filter 2', 'EN'),
(175, 'PARAMETERS', 'PARAM_NAME', 24, 'Activar Filtro Horario 2', 'ES'),
(176, 'PARAMETERS', 'PARAM_NAME', 25, 'Start Time 2', 'EN'),
(177, 'PARAMETERS', 'PARAM_NAME', 25, 'Hora Inicio 2', 'ES'),
(178, 'PARAMETERS', 'PARAM_NAME', 26, 'End Time 2', 'EN'),
(179, 'PARAMETERS', 'PARAM_NAME', 26, 'Hora Fin 2', 'ES'),
(180, 'PARAMETERS', 'PARAM_NAME', 27, 'Enable Time Filter 3', 'EN'),
(181, 'PARAMETERS', 'PARAM_NAME', 27, 'Activar Filtro Horario 3', 'ES'),
(182, 'PARAMETERS', 'PARAM_NAME', 28, 'Start Time 3', 'EN'),
(183, 'PARAMETERS', 'PARAM_NAME', 28, 'Hora Inicio 3', 'ES'),
(184, 'PARAMETERS', 'PARAM_NAME', 29, 'End Time 3', 'EN'),
(185, 'PARAMETERS', 'PARAM_NAME', 29, 'Hora Fin 3', 'ES'),
(186, 'PARAMETERS', 'PARAM_NAME', 33, 'Take Profit For', 'EN'),
(187, 'PARAMETERS', 'PARAM_NAME', 33, 'Take Profit Cuando', 'ES'),
(188, 'PARAMETERS', 'PARAM_NAME', 34, 'Stop Loss For', 'EN'),
(189, 'PARAMETERS', 'PARAM_NAME', 34, 'Stop Loss Cuando', 'ES'),
(190, 'PARAMETERS', 'PARAM_NAME', 30, 'TimeFrame', 'EN'),
(191, 'PARAMETERS', 'PARAM_NAME', 30, 'TimeFrame', 'ES'),
(192, 'PARAMETERS', 'PARAM_NAME', 31, 'Supports For', 'EN'),
(193, 'PARAMETERS', 'PARAM_NAME', 31, 'Soportes Para', 'ES'),
(194, 'PARAMETERS', 'PARAM_NAME', 32, 'Resistances For', 'EN'),
(195, 'PARAMETERS', 'PARAM_NAME', 32, 'Resistencias Para', 'ES'),
(196, 'PARAMETERS', 'PARAM_NAME', 36, 'TimeFrame', 'ES'),
(197, 'PARAMETERS', 'PARAM_NAME', 35, 'Candles Num.', 'EN'),
(198, 'PARAMETERS', 'PARAM_NAME', 35, 'Núm. Velas', 'ES'),
(199, 'PARAMETERS', 'PARAM_NAME', 36, 'TimeFrame', 'EN'),
(200, 'PARAMETERS', 'PARAM_NAME', 37, 'Low For', 'EN'),
(201, 'PARAMETERS', 'PARAM_NAME', 37, 'Min. Para', 'ES'),
(202, 'PARAMETERS', 'PARAM_NAME', 38, 'High For', 'EN'),
(203, 'PARAMETERS', 'PARAM_NAME', 38, 'Max. Para', 'ES'),
(204, 'PARAMETERS', 'PARAM_NAME', 39, 'Pips Margin', 'EN'),
(205, 'PARAMETERS', 'PARAM_NAME', 39, 'Margen Pips', 'ES'),
(206, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 8, 'Element to set action to open an order.', 'EN'),
(207, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 8, 'Elemento para configurar la acción de abrir una orden.', 'ES'),
(208, 'ELEMENTS', 'ELEMENT_NAME', 8, 'Opern Order', 'EN'),
(209, 'ELEMENTS', 'ELEMENT_NAME', 8, 'Abrir Orden', 'ES'),
(210, 'PARAMETERS', 'PARAM_NAME', 41, 'Pips Spread', 'EN'),
(211, 'PARAMETERS', 'PARAM_NAME', 41, 'Pips Spread', 'ES'),
(214, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 7, 'This element is used to separate previous from next elements, in order to define an order sequence (first previous and then next).', 'EN'),
(215, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 7, 'Este elemento es usado para separar condiciones de elementos anteriores de condiciones posteriores, para así definir un orden de sequencia (primero lo anterior, después lo siguiente).', 'ES'),
(216, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 25, 'This element gives signal once price touch last candle/s high and low, for a chosen timeframe.', 'EN'),
(217, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 25, 'Se trata de un elemento que ofrece señal sobre los máximos y mínimos de la/s última/s vela/s en el timeframe seleccionado.', 'ES'),
(218, 'ELEMENTS', 'ELEMENT_NAME', 9, 'Modificar Orden', 'ES'),
(219, 'ELEMENTS', 'ELEMENT_NAME', 10, 'Cerrar Orden', 'ES'),
(220, '', 'ELEMENT_DESCRIPTION', 0, '', ''),
(221, 'ELEMENTS', 'ELEMENT_NAME', 9, 'Modify Order', 'EN'),
(222, 'ELEMENTS', 'ELEMENT_NAME', 10, 'Close Order', 'EN'),
(223, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 9, 'Element to set action to modify order.', 'EN'),
(224, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 9, 'Elemento para configurar la acción de modificar orden.', 'ES'),
(225, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 10, 'Elemento para configuración la acción de cerrar orden.', 'ES'),
(226, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 10, 'Element for set action to close order.', 'EN'),
(228, 'PARAMETERS', 'PARAM_NAME', 43, 'Allow multiple orders', 'EN'),
(229, 'PARAMETERS', 'PARAM_NAME', 43, 'Permitir órdenes adicionales', 'ES'),
(230, 'PARAMETERS', 'PARAM_NAME', 44, 'Volumen Orden', 'ES'),
(231, 'PARAMETERS', 'PARAM_NAME', 44, 'Orders Lots', 'EN'),
(232, 'PARAMETERS', 'PARAM_NAME', 16, 'double type', 'ES'),
(233, 'PARAMETERS', 'PARAM_NAME', 16, 'double type', 'EN'),
(234, 'PARAMETERS', 'PARAM_NAME', 48, 'Texto de Alerta', 'ES'),
(235, 'PARAMETERS', 'PARAM_NAME', 48, 'Alert Text', 'EN'),
(236, 'PARAMETERS', 'PARAM_NAME', 45, 'Permitir Compras', 'ES'),
(237, 'PARAMETERS', 'PARAM_NAME', 45, 'Allow Buys', 'EN'),
(238, 'PARAMETERS', 'PARAM_NAME', 46, 'Permitir Ventas', 'ES'),
(239, 'PARAMETERS', 'PARAM_NAME', 46, 'Allow Sells', 'EN'),
(240, 'PARAMETERS', 'PARAM_NAME', 47, 'Alerta MT4', 'ES'),
(241, 'PARAMETERS', 'PARAM_NAME', 47, 'Enable Alert', 'EN'),
(242, 'PARAMETERS', 'PARAM_NAME', 49, 'Stop Loss', 'EN'),
(243, 'PARAMETERS', 'PARAM_NAME', 49, 'Stop Loss', 'ES'),
(244, 'PARAMETERS', 'PARAM_NAME', 50, 'Modify', 'EN'),
(245, 'PARAMETERS', 'PARAM_NAME', 50, 'Modificar el:', 'ES'),
(246, 'PARAMETERS', 'PARAM_NAME', 51, 'Pips a modificar:', 'ES'),
(247, 'PARAMETERS', 'PARAM_NAME', 51, 'Pips to define or move(+)/(-)', 'EN'),
(248, 'PARAMETERS', 'PARAM_NAME', 52, 'Validate modify each', 'EN'),
(249, 'PARAMETERS', 'PARAM_NAME', 52, 'Validar modificar cada', 'ES'),
(253, 'PARAMETERS', 'PARAM_NAME', 55, 'Alerta MT4', 'ES'),
(254, 'PARAMETERS', 'PARAM_NAME', 55, 'Enable Alert', 'EN'),
(256, 'PARAMETERS', 'PARAM_NAME', 56, 'Texto alerta:', 'ES'),
(257, 'PARAMETERS', 'PARAM_NAME', 56, 'Alert text:', 'EN'),
(258, 'PARAMETERS', 'PARAM_NAME', 57, 'Apply to:', 'EN'),
(259, 'PARAMETERS', 'PARAM_NAME', 57, 'Aplicar a:', 'ES'),
(260, 'PARAMETERS', 'PARAM_NAME', 58, 'Quantity type', 'EN'),
(261, 'PARAMETERS', 'PARAM_NAME', 58, 'Tipo cantidad', 'ES'),
(262, 'PARAMETERS', 'PARAM_NAME', 59, 'Quantity (lotes o %)', 'EN'),
(263, 'PARAMETERS', 'PARAM_NAME', 59, 'Cantidad (Volumen o %)', 'ES'),
(268, 'PARAMETERS', 'PARAM_NAME', 62, 'Alert on Close', 'EN'),
(269, 'PARAMETERS', 'PARAM_NAME', 62, 'Alerta MT4', 'ES'),
(270, 'PARAMETERS', 'PARAM_NAME', 63, 'Texto de Alerta', 'ES'),
(271, 'PARAMETERS', 'PARAM_NAME', 63, 'Alert Text', 'EN'),
(272, 'PARAMETERS', 'PARAM_NAME', 9, 'Anular secuencia si señal inversa', 'ES'),
(273, 'PARAMETERS', 'PARAM_NAME', 9, 'Cancel sequence if reverse signal', 'EN'),
(274, 'PARAMETERS', 'PARAM_NAME', 64, 'Take Profit', 'EN'),
(275, 'PARAMETERS', 'PARAM_NAME', 64, 'Take Profit', 'ES'),
(276, 'ELEMENTS', 'ELEMENT_NAME', 11, 'Beneficio Pips', 'ES'),
(277, 'ELEMENTS', 'ELEMENT_NAME', 12, 'Pérdidas Pips', 'ES'),
(278, 'ELEMENTS', 'ELEMENT_NAME', 32, 'Porcentaje Take Profit', 'ES'),
(279, 'ELEMENTS', 'ELEMENT_NAME', 32, 'Take Profit Percentaje', 'EN'),
(280, 'PARAMETERS', 'PARAM_NAME', 73, 'Porcentaje Take Profit', 'ES'),
(281, 'PARAMETERS', 'PARAM_NAME', 73, 'Profit Percentaje', 'EN'),
(282, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 32, 'Elemento que da señal al conseguir un porcentaje de recorrido respecto al TP.', 'ES'),
(283, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 32, 'This element validates if an order gets a certain percentaje distance considering take profit.', 'EN'),
(284, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 27, 'Elemento que se activa a cierta hora del broker.', 'ES'),
(285, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 27, 'Element who validates if now is some certain broker time.', 'EN'),
(288, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 23, 'Elemento que da señal cuando el precio cruza una determinada media móvil.', 'ES'),
(289, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 23, 'Element who gives signal when prices croces a certain moving average', 'EN'),
(290, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 26, 'Elemento que da señal basado en ADX.', 'ES'),
(291, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 26, 'Element who gives signal based on ADX.', 'EN'),
(292, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 28, 'Elemento que da señal basado en FDI.', 'ES'),
(293, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 28, 'Element who gives signal based on FDI.', 'EN'),
(294, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 29, 'Elemento que da señal cuando exista una vela mayor que el ATR.', 'ES'),
(295, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 29, 'Element who gives signal when exists a candle bigger thant ATR.', 'EN'),
(296, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 24, 'Elemento que da señal al cruce, rebote o pullback sobre un pivot point.', 'ES'),
(297, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 24, 'Elemento who gives signal when croses o makes a pullback over a pivot point level', 'EN'),
(298, 'ELEMENTS', ' ELEMENT_DESCRIPTION', 11, 'Elemento que da la señal cuando una orden consigue una cantidad de pips', 'ES'),
(299, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 11, 'Element who gives signal when an orden guess a certain pips quantity', 'EN'),
(300, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 12, 'Elemento que da la señal cuando una orden pierde una cantidad de pips', 'ES'),
(301, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 12, 'Element who gives signal when an orden loss a certain pips quantity', 'EN'),
(302, 'PARAMETERS', 'PARAM_NAME', 65, 'TIck o Cierre de Vela', 'ES'),
(304, 'PARAMETERS', 'PARAM_NAME', 76, 'Nivel Sobreventa', 'ES'),
(305, 'PARAMETERS', 'PARAM_NAME', 76, 'Oversold Level', 'EN'),
(310, 'PARAMETERS', 'PARAM_NAME', 75, 'Overbought Level', 'EN'),
(311, 'PARAMETERS', 'PARAM_NAME', 75, 'Nivel Sobrecompra', 'ES'),
(312, 'PARAMETERS', 'PARAM_NAME', 77, 'Zona de acción', 'ES'),
(313, 'PARAMETERS', 'PARAM_NAME', 77, 'Action zone:', 'EN'),
(314, 'PARAMETERS', 'PARAM_NAME', 78, 'Timeframe:', 'EN'),
(315, 'PARAMETERS', 'PARAM_NAME', 78, 'Timeframe:', 'ES'),
(316, '(DOWNLOAD_SCREEN)', 'STRAT_DEF_TEXT', 0, 'Strategy definition', 'EN'),
(318, '(DOWNLOAD_SCREEN)', 'STRAT_DEF_TEXT', 0, 'Definición de estrategia', 'ES'),
(319, '(DOWNLOAD_SCREEN)', 'UNDERSTAND_STRAT_TEXT', 0, 'I\'ve read and understand system definition.', 'EN'),
(320, '(DOWNLOAD_SCREEN)', 'UNDERSTAND_STRAT_TEXT', 0, 'He leído y entiendo la definición de la estrategia.', 'ES'),
(322, '(DOWNLOAD_SCREEN)', 'AGREE_COND', 0, 'I\'ve read and agree general conditions.', 'EN'),
(323, '(DOWNLOAD_SCREEN)', 'AGREE_COND', 0, 'He leído y acepto las condiciones generales.', 'ES'),
(324, '(DOWNLOAD_SCREEN)', 'CONDITION_URL', 0, '/conditions_url', 'EN'),
(326, '(DOWNLOAD_SCREEN)', 'CONDITION_URL', 0, '/conditions_url', 'ES'),
(327, '(DOWNLOAD SCREEN)', 'DOWN_BUTTON', 0, 'Pay & Download', 'EN'),
(328, '(DOWNLOAD SCREEN)', 'DOWN_BUTTON', 0, 'Pagar y descargar', 'ES'),
(329, '(DOWNLOAD SCREEN)', 'PAY_TITLE', 0, 'Datos de pago:', 'ES'),
(330, '(DOWNLOAD SCREEN)', 'PAY_TITLE', 0, 'Payment info:', 'EN'),
(331, '(DOWNLOAD SCREEN)', 'ORDER_TITLE', 0, 'Resumen de pedido:', 'ES'),
(332, '(DOWNLOAD SCREEN)', 'ORDER_TITLE', 0, 'Order summary:', 'EN'),
(333, '(DOWNLOAD SCREEN)', 'ORDER_DESC', 0, 'Descarga de sistema creado en tradEAsy', 'ES'),
(334, '(DOWNLOAD SCREEN)', 'ORDER_DESC', 0, 'Sytem download created on tradEAsy', 'EN'),
(335, '(DOWNLOAD SCREEN)', 'SUBTOTAL', 0, 'Subtotal', 'EN'),
(336, '(DOWNLOAD SCREEN)', 'SUBTOTAL', 0, 'Subtotal', 'ES'),
(337, '(DOWNLOAD SCREEN)', 'TOTAL', 0, 'Total', 'EN'),
(338, '(DOWNLOAD SCREEN)', 'TOTAL', 0, 'Total', 'ES'),
(341, '(DOWNLOAD SCREEN)', 'PAY_TEXT', 0, 'Pagar', 'ES'),
(342, '(DOWNLOAD SCREEN)', 'PAY_TEXT', 0, 'Pay', 'EN'),
(343, '(DOWNLOAD SCREEN)', 'PRICE', 0, '30', 'ES'),
(344, '(DOWNLOAD SCREEN)', 'PRICE', 0, '30', 'EN'),
(345, '(DOWNLOAD SCREEN)', 'ORDER_IMG_URL', 0, 'images/order_desc.png', 'EN'),
(346, '(DOWNLOAD SCREEN)', 'ORDER_IMG_URL', 0, 'images/order_desc.png', 'ES'),
(347, 'ELEMENTS', 'ELEMENT_NAME', 33, 'Estocástico', 'ES'),
(348, 'ELEMENTS', 'ELEMENT_NAME', 34, 'Bandas de Bollinguer', 'ES'),
(349, 'ELEMENTS', 'ELEMENT_NAME', 35, 'CCI', 'ES'),
(350, 'ELEMENTS', 'ELEMENT_NAME', 36, 'Parabólico SAR', 'ES'),
(351, 'ELEMENTS', 'ELEMENT_NAME', 37, 'Williams % R', 'ES'),
(352, 'ELEMENTS', 'ELEMENT_NAME', 39, 'Porcentaje Stop Loss', 'ES'),
(353, 'ELEMENTS', 'ELEMENT_NAME', 40, 'Pérdida Acumulada', 'ES'),
(354, 'ELEMENTS', 'ELEMENT_NAME', 41, 'Beneficio Acumulado', 'ES'),
(355, 'ELEMENTS', 'ELEMENT_NAME', 42, 'Cuenta Ordenes', 'ES'),
(356, 'ELEMENTS', 'ELEMENT_NAME', 43, 'Calendario Diario', 'ES'),
(357, 'ELEMENTS', 'ELEMENT_NAME', 44, 'Esperar tiempo', 'ES'),
(358, 'ELEMENTS', 'ELEMENT_NAME', 45, 'Cada cierto tiempo', 'ES'),
(359, 'ELEMENTS', 'ELEMENT_NAME', 33, 'STOCH', 'EN'),
(360, 'ELEMENTS', 'ELEMENT_NAME', 34, 'BOLL', 'EN'),
(361, 'ELEMENTS', 'ELEMENT_NAME', 35, 'CCI', 'EN'),
(362, 'ELEMENTS', 'ELEMENT_NAME', 36, 'PSAR', 'EN'),
(363, 'ELEMENTS', 'ELEMENT_NAME', 37, 'WILLIAMS', 'EN'),
(364, 'ELEMENTS', 'ELEMENT_NAME', 39, 'Stop Loss Percentaje', 'EN'),
(365, 'ELEMENTS', 'ELEMENT_NAME', 40, 'LOSS_TOTAL', 'EN'),
(366, 'ELEMENTS', 'ELEMENT_NAME', 41, 'PROFIT_TOTAL', 'EN'),
(367, 'ELEMENTS', 'ELEMENT_NAME', 42, 'COUNT_ORD', 'EN'),
(368, 'ELEMENTS', 'ELEMENT_NAME', 43, 'DAILY_FILTER', 'EN'),
(369, 'ELEMENTS', 'ELEMENT_NAME', 44, 'AFTER_X_TIME', 'EN'),
(370, 'ELEMENTS', 'ELEMENT_NAME', 45, 'EVERY_X_TIME', 'EN'),
(371, 'PARAMETERS', 'PARAM_NAME', 79, 'Media rápida al alza para:', 'ES'),
(372, 'PARAMETERS', 'PARAM_NAME', 80, 'Media rápida a la baja para: ', 'ES'),
(373, 'PARAMETERS', 'PARAM_NAME', 81, 'Tipo de señal', 'ES'),
(378, 'PARAMETERS', 'PARAM_NAME', 82, 'Moving Average Period', 'EN'),
(379, 'PARAMETERS', 'PARAM_NAME', 84, 'Tipo de Media Móvil', 'ES'),
(380, 'PARAMETERS', 'PARAM_NAME', 85, 'Precio encima media para:', 'ES'),
(381, 'PARAMETERS', 'PARAM_NAME', 86, 'Precio debajo media para:', 'ES'),
(382, 'PARAMETERS', 'PARAM_NAME', 87, 'Tipo de señal', 'ES'),
(383, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 39, 'Elemento que da señal al conseguir un porcentaje de recorrido respecto al SL.', 'ES'),
(384, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 39, 'This element validates if an order gets a certain percentaje distance considering stop loss..', 'EN'),
(385, 'PARAMETERS', 'PARAM_NAME', 88, 'Porcentaje Take Profit', 'ES'),
(386, 'PARAMETERS', 'PARAM_NAME', 88, 'Profit Percentaje', 'EN'),
(387, 'PARAMETERS', 'PARAM_NAME', 89, 'Pips Distancia Take Profit', 'ES'),
(388, 'PARAMETERS', 'PARAM_NAME', 89, 'Pips Distance Take Profit', 'EN'),
(389, 'PARAMETERS', 'PARAM_NAME', 90, 'Pips Distancia Stop Loss', 'ES'),
(390, 'PARAMETERS', 'PARAM_NAME', 90, 'Pips Distance Stop Loss', 'EN'),
(391, 'ELEMENTS', 'ELEMENT_NAME', 50, 'Distancia TP', 'ES'),
(392, 'ELEMENTS', 'ELEMENT_NAME', 50, 'TP Distance', 'EN'),
(393, 'ELEMENTS', 'ELEMENT_NAME', 51, 'Distancia SL', 'ES'),
(394, 'ELEMENTS', 'ELEMENT_NAME', 51, 'Distance SL', 'EN'),
(395, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 50, 'Elemento para validar la distancia entre el precio actual y el take profit.', 'ES'),
(396, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 50, 'Elements to validate the distance between current price and take profit.', 'EN'),
(397, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 51, 'Elemento para validar la distancia entre el precio actual y el stop loss.', 'ES'),
(398, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 51, 'Elements to validate the distance between current price and stop loss..', 'EN'),
(399, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 40, 'Elemento que da señal al conseguir cierta cantidad de pérdidas en total de órdenes abiertas.', 'ES'),
(400, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 40, 'Element that validates total loss,considering all open orders.', 'EN'),
(401, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 41, 'Elemento que da señal al conseguir cierta cantidad de beneficio en total de órdenes abiertas.', 'ES'),
(402, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 41, 'Element who validates total profit, considering all open orders.', 'EN'),
(403, 'PARAMETERS', 'PARAM_NAME', 91, 'Efectivo total pérdidas:', 'ES'),
(404, 'PARAMETERS', 'PARAM_NAME', 91, 'Cash total loss:', 'EN'),
(405, 'PARAMETERS', 'PARAM_NAME', 92, 'Efectivo total beneficio:', 'ES'),
(406, 'PARAMETERS', 'PARAM_NAME', 92, 'Cash total profit:', 'EN'),
(407, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 43, 'Elemento que da señal cuando existe una cierta cantidad de órdenes en mercado.', 'ES'),
(408, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 43, 'Element that validates how many orders are opened on market', 'EN'),
(409, 'PARAMETERS', 'PARAM_NAME', 93, 'Número de Órdenes:', 'ES'),
(410, 'PARAMETERS', 'PARAM_NAME', 93, 'Number of Orders:', 'EN'),
(411, 'PARAMETERS', 'PARAM_NAME', 94, 'Activar cuando sea:', 'ES'),
(412, 'PARAMETERS', 'PARAM_NAME', 94, 'Active when it be:', 'EN'),
(413, 'PARAMETERS', 'PARAM_NAME', 95, 'Tipo de Orden a contar:', 'ES'),
(414, 'PARAMETERS', 'PARAM_NAME', 95, 'Type of Order to count:', 'EN'),
(415, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 44, 'Elemento que da señal cuando pasa un tiempo determinado después de abrir una orden.', 'ES'),
(416, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 44, 'Element that gives signal when a certain time is passed after openning an order.', 'EN'),
(417, 'PARAMETERS', 'PARAM_NAME', 96, 'Tipo de Tiempo:', 'ES'),
(418, 'PARAMETERS', 'PARAM_NAME', 96, 'Time Type:', 'EN'),
(419, 'PARAMETERS', 'PARAM_NAME', 97, 'Cantidad de Tiempo:', 'ES'),
(420, 'PARAMETERS', 'PARAM_NAME', 97, 'Time Quantity:', 'EN'),
(421, 'ELEMENTS', 'ELEMENT_NAME', 46, 'Configuración de Abrir', 'ES'),
(422, 'ELEMENTS', 'ELEMENT_NAME', 46, 'Open Config', 'EN'),
(423, 'ELEMENTS', 'ELEMENT_NAME', 47, 'Configuración de Modificar', 'ES'),
(424, 'ELEMENTS', 'ELEMENT_NAME', 47, 'Modify Config', 'EN'),
(425, 'ELEMENTS', 'ELEMENT_NAME', 48, 'Configuración de Cerrar', 'ES'),
(426, 'ELEMENTS', 'ELEMENT_NAME', 48, 'Close Config', 'EN'),
(427, 'ELEMENTS', 'ELEMENT_NAME', 49, 'Señal Inversa', 'ES'),
(428, 'ELEMENTS', 'ELEMENT_NAME', 49, 'Reverse Signal', 'EN'),
(430, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 11, 'Elemento que da señal al conseguir cierta cantidad de pips de profit en una orden.', 'ES'),
(431, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 30, 'Elemento que da señal basado en el indicador ADR.', 'ES'),
(432, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 31, 'Elemento que da señal basado en las últimas señales de fractales.', 'ES'),
(433, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 33, 'Elemento basado en indicador Stocástico.', 'ES'),
(434, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 34, 'Elemento basado en indicador Bollinguer.', 'ES'),
(435, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 35, 'Elemento basado en indicador CCI.', 'ES'),
(436, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 36, 'Elemento basado en indicador Parabólico SAR', 'ES'),
(437, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 37, 'Elemento basado en indicador Williams % Range', 'ES'),
(438, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 42, 'Elemento que da señal cuando existe una cierta cantidad de órdenes en mercado.', 'ES'),
(439, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 46, 'Elemento de configuración para abrir órdenes.', 'ES'),
(440, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 47, 'Elemento de configuración para modificar órdenes.', 'ES'),
(441, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 48, 'Elemento de configuración para cerrar órdenes.', 'ES'),
(442, 'ELEMENTS', 'ELEMENT_DESCRIPTION', 49, 'Elemento que da señal cuando se abre una nueva orden y en el mercado existen órdenes del sentido inverso.', 'ES'),
(443, 'PARAMETERS', 'PARAM_NAME', 82, 'Periodo Media Móvil', 'ES'),
(445, 'PARAMETERS', 'PARAM_NAME', 100, 'Aplicar Abrir Compras:', 'ES'),
(446, 'PARAMETERS', 'PARAM_NAME', 101, 'Aplicar Abrir Ventas:', 'ES'),
(447, 'PARAMETERS', 'PARAM_NAME', 102, 'Permitir abrir si existe orden de misma señal ya abierta.', 'ES'),
(449, 'PARAMETERS', 'PARAM_NAME', 104, 'Tipo de lectura:', 'ES'),
(450, 'PARAMETERS', 'PARAM_NAME', 105, 'Segundos Temporizador:', 'ES'),
(451, 'PARAMETERS', 'PARAM_NAME', 106, 'Aplicar Modificar Compras:', 'ES'),
(452, 'PARAMETERS', 'PARAM_NAME', 107, 'Aplicar Modificar Ventas:', 'ES'),
(453, 'PARAMETERS', 'PARAM_NAME', 108, 'Tipo de lectura:', 'ES'),
(454, 'PARAMETERS', 'PARAM_NAME', 109, 'Segundos Temporizador:', 'ES'),
(455, 'PARAMETERS', 'PARAM_NAME', 110, 'Aplicar Cerrar Compras:', 'ES'),
(456, 'PARAMETERS', 'PARAM_NAME', 111, 'Aplicar Cerrar Ventas:', 'ES'),
(457, 'PARAMETERS', 'PARAM_NAME', 114, 'Tipo de lectura:', 'ES'),
(458, 'PARAMETERS', 'PARAM_NAME', 115, 'Segundos Temporizador:', 'ES'),
(459, 'PARAMETERS', 'PARAM_NAME', 116, 'Alerta Móvil:', 'ES'),
(460, 'PARAMETERS', 'PARAM_NAME', 117, 'Alerta Mail:', 'ES'),
(461, 'PARAMETERS', 'PARAM_NAME', 118, 'Alerta Móvil:', 'ES'),
(462, 'PARAMETERS', 'PARAM_NAME', 120, 'Alerta Mail:', 'ES'),
(463, 'PARAMETERS', 'PARAM_NAME', 121, 'Alerta Móvil:', 'ES'),
(464, 'PARAMETERS', 'PARAM_NAME', 122, 'Alerta Mail:', 'ES'),
(465, 'PARAMETERS', 'PARAM_NAME', 123, 'Permitir Lunes:', 'ES'),
(466, 'PARAMETERS', 'PARAM_NAME', 124, 'Permitir Martes:', 'ES'),
(467, 'PARAMETERS', 'PARAM_NAME', 125, 'Permitir Miércoles:', 'ES'),
(468, 'PARAMETERS', 'PARAM_NAME', 126, 'Permitir Jueves:', 'ES'),
(469, 'PARAMETERS', 'PARAM_NAME', 127, 'Permitir Viernes:', 'ES'),
(470, 'PARAMETERS', 'PARAM_NAME', 128, 'Permitir Sábado:', 'ES'),
(471, 'PARAMETERS', 'PARAM_NAME', 129, 'Permitir Domingo:', 'ES'),
(472, 'PARAMETERS', 'PARAM_NAME', 130, 'Hora fija:', 'ES'),
(473, 'PARAMETERS', 'PARAM_NAME', 131, 'Contar últimas velas o num. fractales:', 'ES'),
(474, 'PARAMETERS', 'PARAM_NAME', 132, 'Cantidad velas o fractales:', 'ES'),
(475, 'PARAMETERS', 'PARAM_NAME', 133, 'Máximo para:', 'ES'),
(476, 'PARAMETERS', 'PARAM_NAME', 134, 'Mínimo para:', 'ES'),
(477, 'PARAMETERS', 'PARAM_NAME', 135, 'ADR 1:', 'ES'),
(478, 'PARAMETERS', 'PARAM_NAME', 136, 'ADR 2:', 'ES'),
(479, 'PARAMETERS', 'PARAM_NAME', 137, 'ADR 3:', 'ES'),
(480, 'PARAMETERS', 'PARAM_NAME', 138, 'Máximo para:', 'ES'),
(481, 'PARAMETERS', 'PARAM_NAME', 139, 'Mínimo para:', 'ES'),
(482, 'DOWNLOAD SCREEN)', 'LABEL_NAME', 0, 'Nombre y Apellidos:', 'ES'),
(483, 'DOWNLOAD SCREEN)', 'LABEL_EMAIL', 0, 'Email:', 'ES'),
(484, 'DOWNLOAD SCREEN)', 'LABEL_PHONE', 0, 'Teléfono:', 'ES'),
(485, 'DOWNLOAD SCREEN)', 'LABEL_ADRESS', 0, 'Dirección:', 'ES'),
(486, 'DOWNLOAD SCREEN)', 'LABEL_CITY', 0, 'Ciudad:', 'ES'),
(487, 'DOWNLOAD SCREEN)', 'LABEL_STATE', 0, 'País:', 'ES'),
(488, 'DOWNLOAD SCREEN)', 'LABEL_ZIP', 0, 'Código Postal:', 'ES'),
(489, 'DOWNLOAD SCREEN)', 'LABEL_CARD', 0, 'Nº de tarjeta:', 'ES'),
(490, 'DOWNLOAD SCREEN)', 'LABEL_VALID', 0, 'Caducidad:', 'ES'),
(491, 'DOWNLOAD SCREEN)', 'LABEL_CVC', 0, 'Código seguridad CVC:', 'ES'),
(492, 'DOWNLOAD SCREEN)', 'LABEL__OR_ENTER', 0, 'O introduce detalles de tarjeta', 'ES'),
(493, 'PARAMETERS', 'PARAM_NAME', 140, 'SobreCompra Para:', 'ES'),
(494, 'PARAMETERS', 'PARAM_NAME', 140, 'OverBought For:', 'EN'),
(495, 'PARAMETERS', 'PARAM_NAME', 141, 'SobreVenta Para:', 'ES'),
(496, 'PARAMETERS', 'PARAM_NAME', 141, 'OverSold For:', 'EN'),
(497, 'PARAMETERS', 'PARAM_NAME', 142, 'Tipo de Señal:', 'ES'),
(499, 'PARAMETERS', 'PARAM_NAME', 142, 'Type of Signal:', 'EN'),
(501, 'PARAMETERS', 'PARAM_NAME', 143, 'Media Exponencial Rápida:', 'ES'),
(502, 'PARAMETERS', 'PARAM_NAME', 144, 'Media Exponencial Lenta:', 'ES'),
(503, 'PARAMETERS', 'PARAM_NAME', 145, 'Media MACD:', 'ES'),
(504, 'PARAMETERS', 'PARAM_NAME', 146, 'TimeFrame:', 'ES'),
(505, 'PARAMETERS', 'PARAM_NAME', 147, 'Cruce al Alza Para:', 'ES'),
(506, 'PARAMETERS', 'PARAM_NAME', 148, 'Cruce a la Baja Para:', 'ES'),
(507, 'PARAMETERS', 'PARAM_NAME', 149, 'Tipo de Señal:', 'ES'),
(508, 'PARAMETERS', 'PARAM_NAME', 150, 'Periodos ADX:', 'ES'),
(509, 'PARAMETERS', 'PARAM_NAME', 151, 'Usar Nivel ADX', 'ES'),
(510, 'PARAMETERS', 'PARAM_NAME', 152, 'Nivel Entrada ADX:', 'ES'),
(511, 'PARAMETERS', 'PARAM_NAME', 153, 'TimeFrame:', 'ES'),
(512, 'PARAMETERS', 'PARAM_NAME', 154, 'ADX +DI por encima -DI para:', 'ES'),
(513, 'PARAMETERS', 'PARAM_NAME', 155, 'ADX +DI por debajo -DI para:', 'ES'),
(514, 'PARAMETERS', 'PARAM_NAME', 156, 'Tipo de Señal:', 'ES'),
(515, 'PARAMETERS', 'PARAM_NAME', 157, 'Periodos FDI:', 'ES'),
(516, 'PARAMETERS', 'PARAM_NAME', 158, 'Nivel FDI:', 'ES'),
(517, 'PARAMETERS', 'PARAM_NAME', 159, 'TimeFrame:', 'ES'),
(518, 'PARAMETERS', 'PARAM_NAME', 160, 'Zona de Señal:', 'ES'),
(519, 'PARAMETERS', 'PARAM_NAME', 161, 'Tipo de Señal:', 'ES'),
(520, 'PARAMETERS', 'PARAM_NAME', 162, 'Periodo ATR:', 'ES'),
(521, 'PARAMETERS', 'PARAM_NAME', 163, 'TimeFrame:', 'ES'),
(522, 'PARAMETERS', 'PARAM_NAME', 164, 'Factor ATR:', 'ES'),
(523, 'PARAMETERS', 'PARAM_NAME', 165, 'Tipo de Señal:', 'ES'),
(524, 'PARAMETERS', 'PARAM_NAME', 166, 'Nivel K:', 'ES'),
(525, 'PARAMETERS', 'PARAM_NAME', 167, 'Nivel D:', 'ES'),
(526, 'PARAMETERS', 'PARAM_NAME', 168, 'Ralentización:', 'ES'),
(527, 'PARAMETERS', 'PARAM_NAME', 169, 'TimeFrame:', 'ES'),
(528, 'PARAMETERS', 'PARAM_NAME', 170, 'Usar Filtro Niveles:', 'ES'),
(529, 'PARAMETERS', 'PARAM_NAME', 171, 'Nivel Superior:', 'ES'),
(530, 'PARAMETERS', 'PARAM_NAME', 172, 'Nivel Inferior:', 'ES'),
(531, 'PARAMETERS', 'PARAM_NAME', 173, 'Cruce al Alza Para:', 'ES'),
(532, 'PARAMETERS', 'PARAM_NAME', 174, 'Cruce a la Baja Para:', 'ES'),
(533, 'PARAMETERS', 'PARAM_NAME', 175, 'Tipo de Señal:', 'ES'),
(534, 'PARAMETERS', 'PARAM_NAME', 176, 'Periodo Bollinger:', 'ES'),
(535, 'PARAMETERS', 'PARAM_NAME', 177, 'Desviación Bollinger:', 'ES'),
(536, 'PARAMETERS', 'PARAM_NAME', 178, 'TimeFrame:', 'ES'),
(537, 'PARAMETERS', 'PARAM_NAME', 179, 'Zona de Señal:', 'ES'),
(538, 'PARAMETERS', 'PARAM_NAME', 180, 'Nivel Superior Para:', 'ES'),
(539, 'PARAMETERS', 'PARAM_NAME', 181, 'Nivel Inferior Para:', 'ES'),
(540, 'PARAMETERS', 'PARAM_NAME', 182, 'Banda Medio Para:', 'ES'),
(541, 'PARAMETERS', 'PARAM_NAME', 183, 'Tipo de Señal:', 'ES'),
(542, 'PARAMETERS', 'PARAM_NAME', 184, 'Periodo CCI:', 'ES'),
(543, 'PARAMETERS', 'PARAM_NAME', 185, 'Nivel Superior CCI:', 'ES'),
(544, 'PARAMETERS', 'PARAM_NAME', 186, 'Nivel Inferior CCI:', 'ES'),
(545, 'PARAMETERS', 'PARAM_NAME', 187, 'TimeFrame:', 'ES'),
(546, 'PARAMETERS', 'PARAM_NAME', 188, 'Zona de Señal:', 'ES'),
(547, 'PARAMETERS', 'PARAM_NAME', 189, 'Nivel Superior Para:', 'ES'),
(548, 'PARAMETERS', 'PARAM_NAME', 190, 'Nivel Inferior Para:', 'ES'),
(549, 'PARAMETERS', 'PARAM_NAME', 191, 'Tipo de Señal:', 'ES'),
(550, 'PARAMETERS', 'PARAM_NAME', 192, 'Paso:', 'ES'),
(551, 'PARAMETERS', 'PARAM_NAME', 193, 'Máximo:', 'ES'),
(552, 'PARAMETERS', 'PARAM_NAME', 194, 'TimeFrame:', 'ES'),
(553, 'PARAMETERS', 'PARAM_NAME', 195, 'Parabolic SAR Encima Precio Para:', 'ES'),
(554, 'PARAMETERS', 'PARAM_NAME', 196, 'Parabolic SAR Debajo Precio Para:', 'ES'),
(555, 'PARAMETERS', 'PARAM_NAME', 197, 'Tipo de Señal:', 'ES'),
(556, 'PARAMETERS', 'PARAM_NAME', 198, 'Periodo Williams:', 'ES'),
(557, 'PARAMETERS', 'PARAM_NAME', 199, 'TimeFrame:', 'ES'),
(558, 'PARAMETERS', 'PARAM_NAME', 200, 'Nivel Superior:', 'ES'),
(559, 'PARAMETERS', 'PARAM_NAME', 201, 'Nivel Inferior:', 'ES'),
(560, 'PARAMETERS', 'PARAM_NAME', 202, 'Nivel Inferior Para:', 'ES'),
(561, 'PARAMETERS', 'PARAM_NAME', 203, 'Nivel Superior Para:', 'ES'),
(562, 'PARAMETERS', 'PARAM_NAME', 204, 'Zona de Señal:', 'ES'),
(563, 'PARAMETERS', 'PARAM_NAME', 205, 'Tipo de Señal:', 'ES'),
(564, 'PARAMETERS', 'PARAM_NAME', 206, 'TimeFrame', 'ES'),
(565, 'PARAMETERS', 'PARAM_NAME', 207, 'TimeFrame', 'ES');

-- --------------------------------------------------------

--
-- Table structure for table `wp_payment`
--

CREATE TABLE `wp_payment` (
  `payment_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_amount` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_payment`
--

INSERT INTO `wp_payment` (`payment_id`, `session_id`, `user_id`, `payment_amount`, `date`) VALUES
(1, 9, 5, 2500, '2019-03-29'),
(2, 9, 5, 25, '2019-03-21'),
(3, 5, 53, 250000, '2019-03-21'),
(4, 9, 0, 250000, '2019-03-21'),
(5, 18, 3, 2500, '2019-03-15'),
(6, 18, 0, 2500, '2019-03-16'),
(7, 18, 55, 25, '2019-03-16'),
(8, 18, 0, 25, '2019-03-16'),
(9, 18, 0, 25, '2019-03-16'),
(10, 18, 0, 25, '2019-03-16'),
(11, 18, 0, 25, '2019-03-16'),
(12, 18, 0, 25, '2019-03-16'),
(13, 18, 0, 25, '2019-03-16'),
(14, 18, 0, 25, '2019-03-18'),
(15, 18, 0, 25, '2019-03-18'),
(16, 18, 0, 25, '2019-03-18'),
(17, 18, 0, 25, '2019-03-18'),
(18, 18, 0, 25, '2019-03-18'),
(19, 18, 0, 25, '2019-03-18'),
(20, 18, 0, 25, '2019-03-18'),
(21, 18, 0, 25, '2019-03-18'),
(22, 18, 0, 25, '2019-03-18'),
(23, 18, 0, 25, '2019-03-18'),
(24, 18, 0, 25, '2019-03-18'),
(25, 18, 0, 25, '2019-03-18'),
(26, 18, 0, 25, '2019-03-18'),
(27, 18, 0, 30, '2019-03-26'),
(28, 18, 0, 30, '2019-03-26'),
(29, 18, 0, 30, '2019-03-26'),
(30, 18, 0, 30, '2019-03-26'),
(31, 18, 0, 30, '2019-03-26'),
(32, 18, 0, 30, '2019-03-26'),
(33, 18, 0, 30, '2019-03-26'),
(34, 18, 0, 30, '2019-03-26'),
(35, 18, 0, 30, '2019-03-26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`BLOCK_ID`) USING BTREE;

--
-- Indexes for table `cola_compilacion`
--
ALTER TABLE `cola_compilacion`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- Indexes for table `elements`
--
ALTER TABLE `elements`
  ADD PRIMARY KEY (`ELEMENT_ID`) USING BTREE;

--
-- Indexes for table `element_group`
--
ALTER TABLE `element_group`
  ADD PRIMARY KEY (`GROUP_ID`) USING BTREE;

--
-- Indexes for table `error`
--
ALTER TABLE `error`
  ADD PRIMARY KEY (`ERROR_CODE`,`LANG_ID`);

--
-- Indexes for table `languajes`
--
ALTER TABLE `languajes`
  ADD PRIMARY KEY (`LANGUAJE_ID`) USING BTREE;

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`PARAM_ID`) USING BTREE,
  ADD KEY `FK_PARAMETERS_1` (`PARAM_TYPE`) USING BTREE;

--
-- Indexes for table `payment_keys`
--
ALTER TABLE `payment_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_compiled`
--
ALTER TABLE `session_compiled`
  ADD PRIMARY KEY (`session_comp_id`);

--
-- Indexes for table `session_payment`
--
ALTER TABLE `session_payment`
  ADD PRIMARY KEY (`session_pay_id`);

--
-- Indexes for table `session_strategy`
--
ALTER TABLE `session_strategy`
  ADD PRIMARY KEY (`sesion_id`) USING BTREE;

--
-- Indexes for table `session_strategy_definition`
--
ALTER TABLE `session_strategy_definition`
  ADD PRIMARY KEY (`session_strat_def_id`),
  ADD KEY `FK_session_strategy_definition_1` (`sesion_id`);

--
-- Indexes for table `session_validation`
--
ALTER TABLE `session_validation`
  ADD PRIMARY KEY (`session_validation_id`);

--
-- Indexes for table `session_validation_chart`
--
ALTER TABLE `session_validation_chart`
  ADD PRIMARY KEY (`chart_seq`,`sesion_val_id`),
  ADD KEY `FK_session_validation_chart_1` (`sesion_val_id`);

--
-- Indexes for table `temp`
--
ALTER TABLE `temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticker`
--
ALTER TABLE `ticker`
  ADD PRIMARY KEY (`TICKER_ID`);

--
-- Indexes for table `timeframes`
--
ALTER TABLE `timeframes`
  ADD PRIMARY KEY (`TF_ID`,`LANGUAJE_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`TRANS_ID`) USING BTREE;

--
-- Indexes for table `wp_payment`
--
ALTER TABLE `wp_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `block`
--
ALTER TABLE `block`
  MODIFY `BLOCK_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cola_compilacion`
--
ALTER TABLE `cola_compilacion`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `elements`
--
ALTER TABLE `elements`
  MODIFY `ELEMENT_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `element_group`
--
ALTER TABLE `element_group`
  MODIFY `GROUP_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `error`
--
ALTER TABLE `error`
  MODIFY `ERROR_CODE` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `parameters`
--
ALTER TABLE `parameters`
  MODIFY `PARAM_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `payment_keys`
--
ALTER TABLE `payment_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `session_compiled`
--
ALTER TABLE `session_compiled`
  MODIFY `session_comp_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `session_payment`
--
ALTER TABLE `session_payment`
  MODIFY `session_pay_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `session_strategy`
--
ALTER TABLE `session_strategy`
  MODIFY `sesion_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `session_strategy_definition`
--
ALTER TABLE `session_strategy_definition`
  MODIFY `session_strat_def_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `session_validation`
--
ALTER TABLE `session_validation`
  MODIFY `session_validation_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;

--
-- AUTO_INCREMENT for table `session_validation_chart`
--
ALTER TABLE `session_validation_chart`
  MODIFY `chart_seq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `temp`
--
ALTER TABLE `temp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `timeframes`
--
ALTER TABLE `timeframes`
  MODIFY `TF_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `TRANS_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=566;

--
-- AUTO_INCREMENT for table `wp_payment`
--
ALTER TABLE `wp_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `session_strategy_definition`
--
ALTER TABLE `session_strategy_definition`
  ADD CONSTRAINT `FK_session_strategy_definition_1` FOREIGN KEY (`sesion_id`) REFERENCES `session_strategy` (`sesion_id`);

--
-- Constraints for table `session_validation_chart`
--
ALTER TABLE `session_validation_chart`
  ADD CONSTRAINT `FK_session_validation_chart_1` FOREIGN KEY (`sesion_val_id`) REFERENCES `session_validation` (`session_validation_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
