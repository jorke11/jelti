--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

--
-- Data for Name: departments; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (1, 'TOTAL NACIONAL', '00', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (2, 'ANTIOQUIA', '05', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (3, 'ATLANTICO', '08', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (4, 'BOGOTA', '11', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (5, 'BOLIVAR', '13', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (6, 'BOYACA', '15', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (7, 'CALDAS', '17', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (8, 'CAQUETA', '18', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (9, 'CAUCA', '19', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (10, 'CESAR', '20', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (11, 'CORDOBA', '23', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (12, 'CUNDINAMARCA', '25', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (13, 'CHOCO', '27', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (14, 'HUILA', '41', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (15, 'LA GUAJIRA', '44', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (16, 'MAGDALENA', '47', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (17, 'META', '50', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (18, 'NARIÑO', '52', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (19, 'N. DE SANTANDER', '54', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (20, 'QUINDIO', '63', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (21, 'RISARALDA', '66', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (22, 'SANTANDER', '68', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (23, 'SUCRE', '70', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (24, 'TOLIMA', '73', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (25, 'VALLE DEL CAUCA', '76', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (26, 'ARAUCA', '81', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (27, 'CASANARE', '85', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (28, 'PUTUMAYO', '86', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (29, 'SAN ANDRES', '88', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (30, 'AMAZONAS', '91', '2017-05-17 00:35:20', '2017-05-17 00:35:20');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (31, 'GUAINIA', '94', '2017-05-17 00:35:21', '2017-05-17 00:35:21');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (32, 'GUAVIARE', '95', '2017-05-17 00:35:21', '2017-05-17 00:35:21');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (33, 'VAUPES', '97', '2017-05-17 00:35:21', '2017-05-17 00:35:21');
INSERT INTO departments (id, description, code, created_at, updated_at) VALUES (34, 'VICHADA', '99', '2017-05-17 00:35:21', '2017-05-17 00:35:21');


--
-- Name: departments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('departments_id_seq', 34, true);


--
-- PostgreSQL database dump complete
--

