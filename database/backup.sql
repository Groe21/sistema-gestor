PGDMP  1    :    	             }            aguilas_del_saber    16.2    16.2 �    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16580    aguilas_del_saber    DATABASE     �   CREATE DATABASE aguilas_del_saber WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Ecuador.1252';
 !   DROP DATABASE aguilas_del_saber;
                emilio    false                        2615    16581    escuela    SCHEMA        CREATE SCHEMA escuela;
    DROP SCHEMA escuela;
                emilio    false                       1255    16582   matricular_estudiante(integer, character varying, character varying, smallint, character varying, numeric, character varying, character varying, integer, integer, character varying, character varying, character varying, integer, character varying, character varying, character varying)    FUNCTION     +  CREATE FUNCTION escuela.matricular_estudiante(p_id_persona integer, p_paralelo character varying, p_codigo_unico character varying, p_condicion smallint, p_tipo_discapacidad character varying, p_porcentaje_discapacidad numeric, p_carnet_discapacidad character varying, p_imagen character varying, p_id_periodo integer, p_id_persona_mama integer, p_ocupacion_mama character varying, p_telefono_mama character varying, p_correo_mama character varying, p_id_persona_papa integer, p_ocupacion_papa character varying, p_telefono_papa character varying, p_correo_papa character varying) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    -- Insertar datos del estudiante
    INSERT INTO escuela.estudiantes (
        id_persona, paralelo, codigo_unico, condicion, tipo_discapacidad, 
        porcentaje_discapacidad, carnet_discapacidad, imagen, id_periodo
    ) VALUES (
        p_id_persona, p_paralelo, p_codigo_unico, p_condicion, p_tipo_discapacidad, 
        p_porcentaje_discapacidad, p_carnet_discapacidad, p_imagen, p_id_periodo
    );

    -- Insertar datos de la madre
    INSERT INTO escuela.madres (
        id_persona, ocupacion, telefono, correo
    ) VALUES (
        p_id_persona_mama, p_ocupacion_mama, p_telefono_mama, p_correo_mama
    );

    -- Insertar datos del padre
    INSERT INTO escuela.padres (
        id_persona, ocupacion, telefono, correo
    ) VALUES (
        p_id_persona_papa, p_ocupacion_papa, p_telefono_papa, p_correo_papa
    );
EXCEPTION
    WHEN OTHERS THEN
        RAISE EXCEPTION 'Error al insertar la matrícula: %', SQLERRM;
END;
$$;
 D  DROP FUNCTION escuela.matricular_estudiante(p_id_persona integer, p_paralelo character varying, p_codigo_unico character varying, p_condicion smallint, p_tipo_discapacidad character varying, p_porcentaje_discapacidad numeric, p_carnet_discapacidad character varying, p_imagen character varying, p_id_periodo integer, p_id_persona_mama integer, p_ocupacion_mama character varying, p_telefono_mama character varying, p_correo_mama character varying, p_id_persona_papa integer, p_ocupacion_papa character varying, p_telefono_papa character varying, p_correo_papa character varying);
       escuela          emilio    false    6                       1255    16583    obtener_profesores()    FUNCTION     �  CREATE FUNCTION escuela.obtener_profesores() RETURNS TABLE(id_persona integer, nombres character varying, apellidos character varying, nombre_paralelo character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT p.id_persona, p.nombres, p.apellidos, pa.nombre_paralelo
    FROM escuela.personas p
    LEFT JOIN escuela.profesores pr ON p.id_persona = pr.id_persona
    LEFT JOIN escuela.paralelos pa ON pr.id_paralelo = pa.id_paralelo
    WHERE p.rol = 'profesor';
END;
$$;
 ,   DROP FUNCTION escuela.obtener_profesores();
       escuela          emilio    false    6                       1255    17364 �  matricular_estudiante(character varying, character varying, character varying, date, character varying, character varying, character varying, character varying, character varying, integer, integer, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying)    FUNCTION     �  CREATE FUNCTION public.matricular_estudiante(p_cedula_estudiante character varying, p_apellidos_estudiante character varying, p_nombres_estudiante character varying, p_fecha_nacimiento date, p_lugar_nacimiento character varying, p_residencia character varying, p_direccion character varying, p_sector character varying, p_foto_estudiante character varying, p_id_paralelo integer, p_id_periodo integer, p_cedula_padre character varying, p_apellidos_padre character varying, p_nombres_padre character varying, p_direccion_padre character varying, p_ocupacion_padre character varying, p_telefono_padre character varying, p_email_padre character varying, p_foto_padre character varying, p_cedula_madre character varying, p_apellidos_madre character varying, p_nombres_madre character varying, p_direccion_madre character varying, p_ocupacion_madre character varying, p_telefono_madre character varying, p_email_madre character varying, p_foto_madre character varying, p_cedula_representante character varying, p_apellidos_representante character varying, p_nombres_representante character varying, p_direccion_representante character varying, p_ocupacion_representante character varying, p_telefono_representante character varying, p_email_representante character varying, p_foto_representante character varying, p_tipo_representante character varying) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
    v_id_padre INTEGER;
    v_id_madre INTEGER;
    v_id_representante INTEGER;
    v_id_estudiante INTEGER;
BEGIN
    -- Insertar datos en la tabla padre_familia
    INSERT INTO escuela.padre_familia (apellidos, nombres, cedula, direccion_domiciliaria, ocupacion_profesion, telefono_celular, email, foto)
    VALUES (p_apellidos_padre, p_nombres_padre, p_cedula_padre, p_direccion_padre, p_ocupacion_padre, p_telefono_padre, p_email_padre, p_foto_padre)
    RETURNING id_padre INTO v_id_padre;

    -- Insertar datos en la tabla madre_familia
    INSERT INTO escuela.madre_familia (apellidos, nombres, cedula, direccion_domiciliaria, ocupacion_profesion, telefono_celular, email, foto)
    VALUES (p_apellidos_madre, p_nombres_madre, p_cedula_madre, p_direccion_madre, p_ocupacion_madre, p_telefono_madre, p_email_madre, p_foto_madre)
    RETURNING id_madre INTO v_id_madre;

    -- Insertar datos en la tabla representante
    INSERT INTO escuela.representante (apellidos, nombres, cedula, direccion_domiciliaria, ocupacion_profesion, telefono_celular, email, foto, tipo)
    VALUES (p_apellidos_representante, p_nombres_representante, p_cedula_representante, p_direccion_representante, p_ocupacion_representante, p_telefono_representante, p_email_representante, p_foto_representante, p_tipo_representante)
    RETURNING id_representante INTO v_id_representante;

    -- Insertar datos en la tabla estudiantes
    INSERT INTO escuela.estudiantes (cedula, apellidos, nombres, fecha_nacimiento, lugar_nacimiento, residencia, direccion, sector, foto, id_paralelo, id_periodo, id_padre, id_madre, id_representante)
    VALUES (p_cedula_estudiante, p_apellidos_estudiante, p_nombres_estudiante, p_fecha_nacimiento, p_lugar_nacimiento, p_residencia, p_direccion, p_sector, p_foto_estudiante, p_id_paralelo, p_id_periodo, v_id_padre, v_id_madre, v_id_representante)
    RETURNING id_estudiante INTO v_id_estudiante;

    -- Insertar datos en la tabla matriculas
    INSERT INTO escuela.matriculas (id_estudiante, id_periodo, id_paralelo)
    VALUES (v_id_estudiante, p_id_periodo, p_id_paralelo);
END;
$$;
 D  DROP FUNCTION public.matricular_estudiante(p_cedula_estudiante character varying, p_apellidos_estudiante character varying, p_nombres_estudiante character varying, p_fecha_nacimiento date, p_lugar_nacimiento character varying, p_residencia character varying, p_direccion character varying, p_sector character varying, p_foto_estudiante character varying, p_id_paralelo integer, p_id_periodo integer, p_cedula_padre character varying, p_apellidos_padre character varying, p_nombres_padre character varying, p_direccion_padre character varying, p_ocupacion_padre character varying, p_telefono_padre character varying, p_email_padre character varying, p_foto_padre character varying, p_cedula_madre character varying, p_apellidos_madre character varying, p_nombres_madre character varying, p_direccion_madre character varying, p_ocupacion_madre character varying, p_telefono_madre character varying, p_email_madre character varying, p_foto_madre character varying, p_cedula_representante character varying, p_apellidos_representante character varying, p_nombres_representante character varying, p_direccion_representante character varying, p_ocupacion_representante character varying, p_telefono_representante character varying, p_email_representante character varying, p_foto_representante character varying, p_tipo_representante character varying);
       public          emilio    false            �            1259    17126    asignaciones    TABLE     �   CREATE TABLE escuela.asignaciones (
    id_asignacion integer NOT NULL,
    id_profesor integer NOT NULL,
    id_paralelo integer NOT NULL
);
 !   DROP TABLE escuela.asignaciones;
       escuela         heap    emilio    false    6            �            1259    17125    asignaciones_id_asignacion_seq    SEQUENCE     �   CREATE SEQUENCE escuela.asignaciones_id_asignacion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE escuela.asignaciones_id_asignacion_seq;
       escuela          emilio    false    225    6            �           0    0    asignaciones_id_asignacion_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE escuela.asignaciones_id_asignacion_seq OWNED BY escuela.asignaciones.id_asignacion;
          escuela          emilio    false    224            �            1259    17456 
   asistencia    TABLE     �   CREATE TABLE escuela.asistencia (
    id_asistencia integer NOT NULL,
    id_estudiante integer NOT NULL,
    fecha date NOT NULL,
    estado character varying(20) NOT NULL
);
    DROP TABLE escuela.asistencia;
       escuela         heap    emilio    false    6            �            1259    17455    asistencia_id_asistencia_seq    SEQUENCE     �   CREATE SEQUENCE escuela.asistencia_id_asistencia_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 4   DROP SEQUENCE escuela.asistencia_id_asistencia_seq;
       escuela          emilio    false    239    6            �           0    0    asistencia_id_asistencia_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE escuela.asistencia_id_asistencia_seq OWNED BY escuela.asistencia.id_asistencia;
          escuela          emilio    false    238            �            1259    17277    estudiantes    TABLE     N  CREATE TABLE escuela.estudiantes (
    id_estudiante integer NOT NULL,
    cedula character varying(10) NOT NULL,
    apellidos character varying(50) NOT NULL,
    nombres character varying(50) NOT NULL,
    fecha_nacimiento date NOT NULL,
    lugar_nacimiento character varying(100) NOT NULL,
    residencia character varying(100) NOT NULL,
    direccion character varying(100) NOT NULL,
    sector character varying(50) NOT NULL,
    foto character varying(255),
    id_paralelo integer,
    id_periodo integer,
    id_padre integer,
    id_madre integer,
    id_representante integer
);
     DROP TABLE escuela.estudiantes;
       escuela         heap    emilio    false    6            �            1259    16716    estudiantes_id_estudiante_seq    SEQUENCE     �   CREATE SEQUENCE escuela.estudiantes_id_estudiante_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE escuela.estudiantes_id_estudiante_seq;
       escuela          emilio    false    6            �            1259    17276    estudiantes_id_estudiante_seq1    SEQUENCE     �   CREATE SEQUENCE escuela.estudiantes_id_estudiante_seq1
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE escuela.estudiantes_id_estudiante_seq1;
       escuela          emilio    false    231    6            �           0    0    estudiantes_id_estudiante_seq1    SEQUENCE OWNED BY     b   ALTER SEQUENCE escuela.estudiantes_id_estudiante_seq1 OWNED BY escuela.estudiantes.id_estudiante;
          escuela          emilio    false    230            �            1259    17259    madre_familia    TABLE     �  CREATE TABLE escuela.madre_familia (
    id_madre integer NOT NULL,
    apellidos character varying(50) NOT NULL,
    nombres character varying(50) NOT NULL,
    cedula character varying(10) NOT NULL,
    direccion_domiciliaria character varying(100) NOT NULL,
    ocupacion_profesion character varying(50) NOT NULL,
    telefono_celular character varying(15) NOT NULL,
    email character varying(50) NOT NULL,
    foto character varying(255)
);
 "   DROP TABLE escuela.madre_familia;
       escuela         heap    emilio    false    6            �            1259    17258    madre_familia_id_madre_seq    SEQUENCE     �   CREATE SEQUENCE escuela.madre_familia_id_madre_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE escuela.madre_familia_id_madre_seq;
       escuela          emilio    false    229    6            �           0    0    madre_familia_id_madre_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE escuela.madre_familia_id_madre_seq OWNED BY escuela.madre_familia.id_madre;
          escuela          emilio    false    228            �            1259    17333 
   matriculas    TABLE     �   CREATE TABLE escuela.matriculas (
    id_matricula integer NOT NULL,
    id_estudiante integer NOT NULL,
    id_periodo integer NOT NULL,
    id_paralelo integer NOT NULL
);
    DROP TABLE escuela.matriculas;
       escuela         heap    emilio    false    6            �            1259    17332    matriculas_id_matricula_seq    SEQUENCE     �   CREATE SEQUENCE escuela.matriculas_id_matricula_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE escuela.matriculas_id_matricula_seq;
       escuela          emilio    false    6    233            �           0    0    matriculas_id_matricula_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE escuela.matriculas_id_matricula_seq OWNED BY escuela.matriculas.id_matricula;
          escuela          emilio    false    232            �            1259    17250    padre_familia    TABLE     �  CREATE TABLE escuela.padre_familia (
    id_padre integer NOT NULL,
    apellidos character varying(50) NOT NULL,
    nombres character varying(50) NOT NULL,
    cedula character varying(10) NOT NULL,
    direccion_domiciliaria character varying(100) NOT NULL,
    ocupacion_profesion character varying(50) NOT NULL,
    telefono_celular character varying(15) NOT NULL,
    email character varying(50) NOT NULL,
    foto character varying(255)
);
 "   DROP TABLE escuela.padre_familia;
       escuela         heap    emilio    false    6            �            1259    17249    padre_familia_id_padre_seq    SEQUENCE     �   CREATE SEQUENCE escuela.padre_familia_id_padre_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE escuela.padre_familia_id_padre_seq;
       escuela          emilio    false    6    227            �           0    0    padre_familia_id_padre_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE escuela.padre_familia_id_padre_seq OWNED BY escuela.padre_familia.id_padre;
          escuela          emilio    false    226            �            1259    16601 	   paralelos    TABLE     y   CREATE TABLE escuela.paralelos (
    id_paralelo integer NOT NULL,
    nombre_paralelo character varying(30) NOT NULL
);
    DROP TABLE escuela.paralelos;
       escuela         heap    emilio    false    6            �            1259    16604    paralelos_id_paralelo_seq    SEQUENCE     �   CREATE SEQUENCE escuela.paralelos_id_paralelo_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE escuela.paralelos_id_paralelo_seq;
       escuela          emilio    false    216    6            �           0    0    paralelos_id_paralelo_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE escuela.paralelos_id_paralelo_seq OWNED BY escuela.paralelos.id_paralelo;
          escuela          emilio    false    217            �            1259    16605    periodos_lectivos    TABLE     �   CREATE TABLE escuela.periodos_lectivos (
    id_periodo integer NOT NULL,
    nombre_periodo character varying(50) NOT NULL,
    fecha_inicio date NOT NULL,
    fecha_fin date NOT NULL
);
 &   DROP TABLE escuela.periodos_lectivos;
       escuela         heap    emilio    false    6            �            1259    16608     periodos_lectivos_id_periodo_seq    SEQUENCE     �   CREATE SEQUENCE escuela.periodos_lectivos_id_periodo_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE escuela.periodos_lectivos_id_periodo_seq;
       escuela          emilio    false    218    6            �           0    0     periodos_lectivos_id_periodo_seq    SEQUENCE OWNED BY     g   ALTER SEQUENCE escuela.periodos_lectivos_id_periodo_seq OWNED BY escuela.periodos_lectivos.id_periodo;
          escuela          emilio    false    219            �            1259    16609    personas_id_persona_seq    SEQUENCE     �   CREATE SEQUENCE escuela.personas_id_persona_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE escuela.personas_id_persona_seq;
       escuela          emilio    false    6            �            1259    17439 
   profesores    TABLE     �   CREATE TABLE escuela.profesores (
    id_profesor integer NOT NULL,
    nombre character varying(255) NOT NULL,
    id_periodo integer NOT NULL,
    id_paralelo integer
);
    DROP TABLE escuela.profesores;
       escuela         heap    emilio    false    6            �            1259    17438    profesores_id_profesor_seq    SEQUENCE     �   CREATE SEQUENCE escuela.profesores_id_profesor_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE escuela.profesores_id_profesor_seq;
       escuela          emilio    false    6    237            �           0    0    profesores_id_profesor_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE escuela.profesores_id_profesor_seq OWNED BY escuela.profesores.id_profesor;
          escuela          emilio    false    236            �            1259    17429    representante    TABLE     �  CREATE TABLE escuela.representante (
    id_representante integer NOT NULL,
    apellidos character varying(50) NOT NULL,
    nombres character varying(50) NOT NULL,
    cedula character varying(10) NOT NULL,
    direccion_domiciliaria character varying(100) NOT NULL,
    ocupacion_profesion character varying(50) NOT NULL,
    telefono_celular character varying(15) NOT NULL,
    email character varying(50) NOT NULL,
    foto character varying(255),
    tipo character varying(20) NOT NULL,
    CONSTRAINT representante_tipo_check CHECK (((tipo)::text = ANY ((ARRAY['mama'::character varying, 'papa'::character varying, 'hermano/a'::character varying, 'tio/a'::character varying, 'abuelo/a'::character varying, 'otro'::character varying])::text[])))
);
 "   DROP TABLE escuela.representante;
       escuela         heap    emilio    false    6            �            1259    17428 "   representante_id_representante_seq    SEQUENCE     �   CREATE SEQUENCE escuela.representante_id_representante_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 :   DROP SEQUENCE escuela.representante_id_representante_seq;
       escuela          emilio    false    235    6            �           0    0 "   representante_id_representante_seq    SEQUENCE OWNED BY     k   ALTER SEQUENCE escuela.representante_id_representante_seq OWNED BY escuela.representante.id_representante;
          escuela          emilio    false    234                       1259    17750    roles    TABLE     g   CREATE TABLE escuela.roles (
    id_rol integer NOT NULL,
    nombre character varying(50) NOT NULL
);
    DROP TABLE escuela.roles;
       escuela         heap    emilio    false    6                       1259    17749    roles_id_rol_seq    SEQUENCE     �   CREATE SEQUENCE escuela.roles_id_rol_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE escuela.roles_id_rol_seq;
       escuela          emilio    false    259    6            �           0    0    roles_id_rol_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE escuela.roles_id_rol_seq OWNED BY escuela.roles.id_rol;
          escuela          emilio    false    258            �            1259    16625    usuarios    TABLE     �   CREATE TABLE escuela.usuarios (
    id_usuario integer NOT NULL,
    id_persona integer,
    username character varying(50) NOT NULL,
    password character varying(255) NOT NULL,
    id_rol integer
);
    DROP TABLE escuela.usuarios;
       escuela         heap    emilio    false    6            �            1259    16628    usuarios_id_usuario_seq    SEQUENCE     �   CREATE SEQUENCE escuela.usuarios_id_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE escuela.usuarios_id_usuario_seq;
       escuela          emilio    false    221    6            �           0    0    usuarios_id_usuario_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE escuela.usuarios_id_usuario_seq OWNED BY escuela.usuarios.id_usuario;
          escuela          emilio    false    222            �            1259    17711    blog    TABLE     �   CREATE TABLE public.blog (
    id integer NOT NULL,
    titulo character varying(255) NOT NULL,
    contenido text NOT NULL,
    imagen character varying(255) NOT NULL
);
    DROP TABLE public.blog;
       public         heap    emilio    false            �            1259    17710    blog_id_seq    SEQUENCE     �   CREATE SEQUENCE public.blog_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.blog_id_seq;
       public          emilio    false    251            �           0    0    blog_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE public.blog_id_seq OWNED BY public.blog.id;
          public          emilio    false    250            �            1259    17720    comunicados    TABLE     �   CREATE TABLE public.comunicados (
    id integer NOT NULL,
    titulo character varying(255) NOT NULL,
    contenido text NOT NULL,
    imagen character varying(255) NOT NULL
);
    DROP TABLE public.comunicados;
       public         heap    emilio    false            �            1259    17719    comunicados_id_seq    SEQUENCE     �   CREATE SEQUENCE public.comunicados_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.comunicados_id_seq;
       public          emilio    false    253            �           0    0    comunicados_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.comunicados_id_seq OWNED BY public.comunicados.id;
          public          emilio    false    252                       1259    17738    fotos    TABLE     �   CREATE TABLE public.fotos (
    id integer NOT NULL,
    galeria_id integer NOT NULL,
    ruta character varying(255) NOT NULL
);
    DROP TABLE public.fotos;
       public         heap    emilio    false                        1259    17737    fotos_id_seq    SEQUENCE     �   CREATE SEQUENCE public.fotos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.fotos_id_seq;
       public          emilio    false    257            �           0    0    fotos_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.fotos_id_seq OWNED BY public.fotos.id;
          public          emilio    false    256            �            1259    17729    galeria    TABLE     �   CREATE TABLE public.galeria (
    id integer NOT NULL,
    titulo character varying(255) NOT NULL,
    descripcion text NOT NULL
);
    DROP TABLE public.galeria;
       public         heap    emilio    false            �            1259    17728    galeria_id_seq    SEQUENCE     �   CREATE SEQUENCE public.galeria_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.galeria_id_seq;
       public          emilio    false    255            �           0    0    galeria_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.galeria_id_seq OWNED BY public.galeria.id;
          public          emilio    false    254            �            1259    17684    nosotros    TABLE     0  CREATE TABLE public.nosotros (
    id integer NOT NULL,
    titulo character varying(255) NOT NULL,
    contenido text NOT NULL,
    imagen_principal character varying(255) NOT NULL,
    imagen_secundaria character varying(255) NOT NULL,
    descripcion1 text NOT NULL,
    descripcion2 text NOT NULL
);
    DROP TABLE public.nosotros;
       public         heap    emilio    false            �            1259    17683    nosotros_id_seq    SEQUENCE     �   CREATE SEQUENCE public.nosotros_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.nosotros_id_seq;
       public          emilio    false    245            �           0    0    nosotros_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.nosotros_id_seq OWNED BY public.nosotros.id;
          public          emilio    false    244            �            1259    17656    padres    TABLE     �   CREATE TABLE public.padres (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    comentario text NOT NULL,
    imagen character varying(255) NOT NULL
);
    DROP TABLE public.padres;
       public         heap    emilio    false            �            1259    17655    padres_id_seq    SEQUENCE     �   CREATE SEQUENCE public.padres_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.padres_id_seq;
       public          emilio    false    241            �           0    0    padres_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.padres_id_seq OWNED BY public.padres.id;
          public          emilio    false    240            �            1259    17702    profesor    TABLE     �   CREATE TABLE public.profesor (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    cargo character varying(255) NOT NULL,
    imagen character varying(255) NOT NULL
);
    DROP TABLE public.profesor;
       public         heap    emilio    false            �            1259    17701    profesor_id_seq    SEQUENCE     �   CREATE SEQUENCE public.profesor_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.profesor_id_seq;
       public          emilio    false    249            �           0    0    profesor_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.profesor_id_seq OWNED BY public.profesor.id;
          public          emilio    false    248            �            1259    17693 	   proyectos    TABLE     �   CREATE TABLE public.proyectos (
    id integer NOT NULL,
    titulo character varying(255) NOT NULL,
    contenido text NOT NULL
);
    DROP TABLE public.proyectos;
       public         heap    emilio    false            �            1259    17692    proyectos_id_seq    SEQUENCE     �   CREATE SEQUENCE public.proyectos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.proyectos_id_seq;
       public          emilio    false    247            �           0    0    proyectos_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.proyectos_id_seq OWNED BY public.proyectos.id;
          public          emilio    false    246            �            1259    17674    tarjetas    TABLE     �   CREATE TABLE public.tarjetas (
    id integer NOT NULL,
    titulo character varying(255) NOT NULL,
    contenido text NOT NULL
);
    DROP TABLE public.tarjetas;
       public         heap    emilio    false            �            1259    17673    tarjetas_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tarjetas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.tarjetas_id_seq;
       public          emilio    false    243            �           0    0    tarjetas_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.tarjetas_id_seq OWNED BY public.tarjetas.id;
          public          emilio    false    242            �           2604    17129    asignaciones id_asignacion    DEFAULT     �   ALTER TABLE ONLY escuela.asignaciones ALTER COLUMN id_asignacion SET DEFAULT nextval('escuela.asignaciones_id_asignacion_seq'::regclass);
 J   ALTER TABLE escuela.asignaciones ALTER COLUMN id_asignacion DROP DEFAULT;
       escuela          emilio    false    225    224    225            �           2604    17459    asistencia id_asistencia    DEFAULT     �   ALTER TABLE ONLY escuela.asistencia ALTER COLUMN id_asistencia SET DEFAULT nextval('escuela.asistencia_id_asistencia_seq'::regclass);
 H   ALTER TABLE escuela.asistencia ALTER COLUMN id_asistencia DROP DEFAULT;
       escuela          emilio    false    238    239    239            �           2604    17280    estudiantes id_estudiante    DEFAULT     �   ALTER TABLE ONLY escuela.estudiantes ALTER COLUMN id_estudiante SET DEFAULT nextval('escuela.estudiantes_id_estudiante_seq1'::regclass);
 I   ALTER TABLE escuela.estudiantes ALTER COLUMN id_estudiante DROP DEFAULT;
       escuela          emilio    false    231    230    231            �           2604    17262    madre_familia id_madre    DEFAULT     �   ALTER TABLE ONLY escuela.madre_familia ALTER COLUMN id_madre SET DEFAULT nextval('escuela.madre_familia_id_madre_seq'::regclass);
 F   ALTER TABLE escuela.madre_familia ALTER COLUMN id_madre DROP DEFAULT;
       escuela          emilio    false    228    229    229            �           2604    17336    matriculas id_matricula    DEFAULT     �   ALTER TABLE ONLY escuela.matriculas ALTER COLUMN id_matricula SET DEFAULT nextval('escuela.matriculas_id_matricula_seq'::regclass);
 G   ALTER TABLE escuela.matriculas ALTER COLUMN id_matricula DROP DEFAULT;
       escuela          emilio    false    233    232    233            �           2604    17253    padre_familia id_padre    DEFAULT     �   ALTER TABLE ONLY escuela.padre_familia ALTER COLUMN id_padre SET DEFAULT nextval('escuela.padre_familia_id_padre_seq'::regclass);
 F   ALTER TABLE escuela.padre_familia ALTER COLUMN id_padre DROP DEFAULT;
       escuela          emilio    false    226    227    227            �           2604    16632    paralelos id_paralelo    DEFAULT     �   ALTER TABLE ONLY escuela.paralelos ALTER COLUMN id_paralelo SET DEFAULT nextval('escuela.paralelos_id_paralelo_seq'::regclass);
 E   ALTER TABLE escuela.paralelos ALTER COLUMN id_paralelo DROP DEFAULT;
       escuela          emilio    false    217    216            �           2604    16633    periodos_lectivos id_periodo    DEFAULT     �   ALTER TABLE ONLY escuela.periodos_lectivos ALTER COLUMN id_periodo SET DEFAULT nextval('escuela.periodos_lectivos_id_periodo_seq'::regclass);
 L   ALTER TABLE escuela.periodos_lectivos ALTER COLUMN id_periodo DROP DEFAULT;
       escuela          emilio    false    219    218            �           2604    17442    profesores id_profesor    DEFAULT     �   ALTER TABLE ONLY escuela.profesores ALTER COLUMN id_profesor SET DEFAULT nextval('escuela.profesores_id_profesor_seq'::regclass);
 F   ALTER TABLE escuela.profesores ALTER COLUMN id_profesor DROP DEFAULT;
       escuela          emilio    false    236    237    237            �           2604    17432    representante id_representante    DEFAULT     �   ALTER TABLE ONLY escuela.representante ALTER COLUMN id_representante SET DEFAULT nextval('escuela.representante_id_representante_seq'::regclass);
 N   ALTER TABLE escuela.representante ALTER COLUMN id_representante DROP DEFAULT;
       escuela          emilio    false    235    234    235            �           2604    17753    roles id_rol    DEFAULT     n   ALTER TABLE ONLY escuela.roles ALTER COLUMN id_rol SET DEFAULT nextval('escuela.roles_id_rol_seq'::regclass);
 <   ALTER TABLE escuela.roles ALTER COLUMN id_rol DROP DEFAULT;
       escuela          emilio    false    258    259    259            �           2604    16635    usuarios id_usuario    DEFAULT     |   ALTER TABLE ONLY escuela.usuarios ALTER COLUMN id_usuario SET DEFAULT nextval('escuela.usuarios_id_usuario_seq'::regclass);
 C   ALTER TABLE escuela.usuarios ALTER COLUMN id_usuario DROP DEFAULT;
       escuela          emilio    false    222    221            �           2604    17714    blog id    DEFAULT     b   ALTER TABLE ONLY public.blog ALTER COLUMN id SET DEFAULT nextval('public.blog_id_seq'::regclass);
 6   ALTER TABLE public.blog ALTER COLUMN id DROP DEFAULT;
       public          emilio    false    251    250    251            �           2604    17723    comunicados id    DEFAULT     p   ALTER TABLE ONLY public.comunicados ALTER COLUMN id SET DEFAULT nextval('public.comunicados_id_seq'::regclass);
 =   ALTER TABLE public.comunicados ALTER COLUMN id DROP DEFAULT;
       public          emilio    false    252    253    253            �           2604    17741    fotos id    DEFAULT     d   ALTER TABLE ONLY public.fotos ALTER COLUMN id SET DEFAULT nextval('public.fotos_id_seq'::regclass);
 7   ALTER TABLE public.fotos ALTER COLUMN id DROP DEFAULT;
       public          emilio    false    257    256    257            �           2604    17732 
   galeria id    DEFAULT     h   ALTER TABLE ONLY public.galeria ALTER COLUMN id SET DEFAULT nextval('public.galeria_id_seq'::regclass);
 9   ALTER TABLE public.galeria ALTER COLUMN id DROP DEFAULT;
       public          emilio    false    254    255    255            �           2604    17687    nosotros id    DEFAULT     j   ALTER TABLE ONLY public.nosotros ALTER COLUMN id SET DEFAULT nextval('public.nosotros_id_seq'::regclass);
 :   ALTER TABLE public.nosotros ALTER COLUMN id DROP DEFAULT;
       public          emilio    false    245    244    245            �           2604    17659 	   padres id    DEFAULT     f   ALTER TABLE ONLY public.padres ALTER COLUMN id SET DEFAULT nextval('public.padres_id_seq'::regclass);
 8   ALTER TABLE public.padres ALTER COLUMN id DROP DEFAULT;
       public          emilio    false    241    240    241            �           2604    17705    profesor id    DEFAULT     j   ALTER TABLE ONLY public.profesor ALTER COLUMN id SET DEFAULT nextval('public.profesor_id_seq'::regclass);
 :   ALTER TABLE public.profesor ALTER COLUMN id DROP DEFAULT;
       public          emilio    false    249    248    249            �           2604    17696    proyectos id    DEFAULT     l   ALTER TABLE ONLY public.proyectos ALTER COLUMN id SET DEFAULT nextval('public.proyectos_id_seq'::regclass);
 ;   ALTER TABLE public.proyectos ALTER COLUMN id DROP DEFAULT;
       public          emilio    false    246    247    247            �           2604    17677    tarjetas id    DEFAULT     j   ALTER TABLE ONLY public.tarjetas ALTER COLUMN id SET DEFAULT nextval('public.tarjetas_id_seq'::regclass);
 :   ALTER TABLE public.tarjetas ALTER COLUMN id DROP DEFAULT;
       public          emilio    false    243    242    243            �          0    17126    asignaciones 
   TABLE DATA           P   COPY escuela.asignaciones (id_asignacion, id_profesor, id_paralelo) FROM stdin;
    escuela          emilio    false    225   2�       �          0    17456 
   asistencia 
   TABLE DATA           R   COPY escuela.asistencia (id_asistencia, id_estudiante, fecha, estado) FROM stdin;
    escuela          emilio    false    239   v�       �          0    17277    estudiantes 
   TABLE DATA           �   COPY escuela.estudiantes (id_estudiante, cedula, apellidos, nombres, fecha_nacimiento, lugar_nacimiento, residencia, direccion, sector, foto, id_paralelo, id_periodo, id_padre, id_madre, id_representante) FROM stdin;
    escuela          emilio    false    231   U�       �          0    17259    madre_familia 
   TABLE DATA           �   COPY escuela.madre_familia (id_madre, apellidos, nombres, cedula, direccion_domiciliaria, ocupacion_profesion, telefono_celular, email, foto) FROM stdin;
    escuela          emilio    false    229   �       �          0    17333 
   matriculas 
   TABLE DATA           [   COPY escuela.matriculas (id_matricula, id_estudiante, id_periodo, id_paralelo) FROM stdin;
    escuela          emilio    false    233   ��       �          0    17250    padre_familia 
   TABLE DATA           �   COPY escuela.padre_familia (id_padre, apellidos, nombres, cedula, direccion_domiciliaria, ocupacion_profesion, telefono_celular, email, foto) FROM stdin;
    escuela          emilio    false    227   7�       �          0    16601 	   paralelos 
   TABLE DATA           B   COPY escuela.paralelos (id_paralelo, nombre_paralelo) FROM stdin;
    escuela          emilio    false    216   8�       �          0    16605    periodos_lectivos 
   TABLE DATA           a   COPY escuela.periodos_lectivos (id_periodo, nombre_periodo, fecha_inicio, fecha_fin) FROM stdin;
    escuela          emilio    false    218   l�       �          0    17439 
   profesores 
   TABLE DATA           S   COPY escuela.profesores (id_profesor, nombre, id_periodo, id_paralelo) FROM stdin;
    escuela          emilio    false    237   ��       �          0    17429    representante 
   TABLE DATA           �   COPY escuela.representante (id_representante, apellidos, nombres, cedula, direccion_domiciliaria, ocupacion_profesion, telefono_celular, email, foto, tipo) FROM stdin;
    escuela          emilio    false    235   7�       �          0    17750    roles 
   TABLE DATA           0   COPY escuela.roles (id_rol, nombre) FROM stdin;
    escuela          emilio    false    259   C�       �          0    16625    usuarios 
   TABLE DATA           W   COPY escuela.usuarios (id_usuario, id_persona, username, password, id_rol) FROM stdin;
    escuela          emilio    false    221   ��       �          0    17711    blog 
   TABLE DATA           =   COPY public.blog (id, titulo, contenido, imagen) FROM stdin;
    public          emilio    false    251   -�       �          0    17720    comunicados 
   TABLE DATA           D   COPY public.comunicados (id, titulo, contenido, imagen) FROM stdin;
    public          emilio    false    253   >      �          0    17738    fotos 
   TABLE DATA           5   COPY public.fotos (id, galeria_id, ruta) FROM stdin;
    public          emilio    false    257   &      �          0    17729    galeria 
   TABLE DATA           :   COPY public.galeria (id, titulo, descripcion) FROM stdin;
    public          emilio    false    255   �      �          0    17684    nosotros 
   TABLE DATA           z   COPY public.nosotros (id, titulo, contenido, imagen_principal, imagen_secundaria, descripcion1, descripcion2) FROM stdin;
    public          emilio    false    245   �      �          0    17656    padres 
   TABLE DATA           @   COPY public.padres (id, nombre, comentario, imagen) FROM stdin;
    public          emilio    false    241   	      �          0    17702    profesor 
   TABLE DATA           =   COPY public.profesor (id, nombre, cargo, imagen) FROM stdin;
    public          emilio    false    249   �	      �          0    17693 	   proyectos 
   TABLE DATA           :   COPY public.proyectos (id, titulo, contenido) FROM stdin;
    public          emilio    false    247   
      �          0    17674    tarjetas 
   TABLE DATA           9   COPY public.tarjetas (id, titulo, contenido) FROM stdin;
    public          emilio    false    243   B      �           0    0    asignaciones_id_asignacion_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('escuela.asignaciones_id_asignacion_seq', 16, true);
          escuela          emilio    false    224            �           0    0    asistencia_id_asistencia_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('escuela.asistencia_id_asistencia_seq', 46, true);
          escuela          emilio    false    238            �           0    0    estudiantes_id_estudiante_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('escuela.estudiantes_id_estudiante_seq', 5, true);
          escuela          emilio    false    223            �           0    0    estudiantes_id_estudiante_seq1    SEQUENCE SET     N   SELECT pg_catalog.setval('escuela.estudiantes_id_estudiante_seq1', 16, true);
          escuela          emilio    false    230            �           0    0    madre_familia_id_madre_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('escuela.madre_familia_id_madre_seq', 29, true);
          escuela          emilio    false    228            �           0    0    matriculas_id_matricula_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('escuela.matriculas_id_matricula_seq', 14, true);
          escuela          emilio    false    232            �           0    0    padre_familia_id_padre_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('escuela.padre_familia_id_padre_seq', 30, true);
          escuela          emilio    false    226            �           0    0    paralelos_id_paralelo_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('escuela.paralelos_id_paralelo_seq', 25, true);
          escuela          emilio    false    217            �           0    0     periodos_lectivos_id_periodo_seq    SEQUENCE SET     P   SELECT pg_catalog.setval('escuela.periodos_lectivos_id_periodo_seq', 19, true);
          escuela          emilio    false    219            �           0    0    personas_id_persona_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('escuela.personas_id_persona_seq', 228, true);
          escuela          emilio    false    220            �           0    0    profesores_id_profesor_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('escuela.profesores_id_profesor_seq', 11, true);
          escuela          emilio    false    236            �           0    0 "   representante_id_representante_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('escuela.representante_id_representante_seq', 12, true);
          escuela          emilio    false    234            �           0    0    roles_id_rol_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('escuela.roles_id_rol_seq', 3, true);
          escuela          emilio    false    258            �           0    0    usuarios_id_usuario_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('escuela.usuarios_id_usuario_seq', 20, true);
          escuela          emilio    false    222            �           0    0    blog_id_seq    SEQUENCE SET     9   SELECT pg_catalog.setval('public.blog_id_seq', 7, true);
          public          emilio    false    250            �           0    0    comunicados_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.comunicados_id_seq', 3, true);
          public          emilio    false    252            �           0    0    fotos_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.fotos_id_seq', 13, true);
          public          emilio    false    256            �           0    0    galeria_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.galeria_id_seq', 4, true);
          public          emilio    false    254            �           0    0    nosotros_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.nosotros_id_seq', 1, true);
          public          emilio    false    244            �           0    0    padres_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.padres_id_seq', 3, true);
          public          emilio    false    240            �           0    0    profesor_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.profesor_id_seq', 6, true);
          public          emilio    false    248            �           0    0    proyectos_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.proyectos_id_seq', 3, true);
          public          emilio    false    246            �           0    0    tarjetas_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.tarjetas_id_seq', 8, true);
          public          emilio    false    242            �           2606    17133 5   asignaciones asignaciones_id_profesor_id_paralelo_key 
   CONSTRAINT     �   ALTER TABLE ONLY escuela.asignaciones
    ADD CONSTRAINT asignaciones_id_profesor_id_paralelo_key UNIQUE (id_profesor, id_paralelo);
 `   ALTER TABLE ONLY escuela.asignaciones DROP CONSTRAINT asignaciones_id_profesor_id_paralelo_key;
       escuela            emilio    false    225    225            �           2606    17131    asignaciones asignaciones_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY escuela.asignaciones
    ADD CONSTRAINT asignaciones_pkey PRIMARY KEY (id_asignacion);
 I   ALTER TABLE ONLY escuela.asignaciones DROP CONSTRAINT asignaciones_pkey;
       escuela            emilio    false    225            �           2606    17461    asistencia asistencia_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY escuela.asistencia
    ADD CONSTRAINT asistencia_pkey PRIMARY KEY (id_asistencia);
 E   ALTER TABLE ONLY escuela.asistencia DROP CONSTRAINT asistencia_pkey;
       escuela            emilio    false    239            �           2606    17284    estudiantes estudiantes_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY escuela.estudiantes
    ADD CONSTRAINT estudiantes_pkey PRIMARY KEY (id_estudiante);
 G   ALTER TABLE ONLY escuela.estudiantes DROP CONSTRAINT estudiantes_pkey;
       escuela            emilio    false    231            �           2606    17266     madre_familia madre_familia_pkey 
   CONSTRAINT     e   ALTER TABLE ONLY escuela.madre_familia
    ADD CONSTRAINT madre_familia_pkey PRIMARY KEY (id_madre);
 K   ALTER TABLE ONLY escuela.madre_familia DROP CONSTRAINT madre_familia_pkey;
       escuela            emilio    false    229            �           2606    17338    matriculas matriculas_pkey 
   CONSTRAINT     c   ALTER TABLE ONLY escuela.matriculas
    ADD CONSTRAINT matriculas_pkey PRIMARY KEY (id_matricula);
 E   ALTER TABLE ONLY escuela.matriculas DROP CONSTRAINT matriculas_pkey;
       escuela            emilio    false    233            �           2606    17257     padre_familia padre_familia_pkey 
   CONSTRAINT     e   ALTER TABLE ONLY escuela.padre_familia
    ADD CONSTRAINT padre_familia_pkey PRIMARY KEY (id_padre);
 K   ALTER TABLE ONLY escuela.padre_familia DROP CONSTRAINT padre_familia_pkey;
       escuela            emilio    false    227            �           2606    16647    paralelos paralelos_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY escuela.paralelos
    ADD CONSTRAINT paralelos_pkey PRIMARY KEY (id_paralelo);
 C   ALTER TABLE ONLY escuela.paralelos DROP CONSTRAINT paralelos_pkey;
       escuela            emilio    false    216            �           2606    16649 (   periodos_lectivos periodos_lectivos_pkey 
   CONSTRAINT     o   ALTER TABLE ONLY escuela.periodos_lectivos
    ADD CONSTRAINT periodos_lectivos_pkey PRIMARY KEY (id_periodo);
 S   ALTER TABLE ONLY escuela.periodos_lectivos DROP CONSTRAINT periodos_lectivos_pkey;
       escuela            emilio    false    218            �           2606    17444    profesores profesores_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY escuela.profesores
    ADD CONSTRAINT profesores_pkey PRIMARY KEY (id_profesor);
 E   ALTER TABLE ONLY escuela.profesores DROP CONSTRAINT profesores_pkey;
       escuela            emilio    false    237            �           2606    17437     representante representante_pkey 
   CONSTRAINT     m   ALTER TABLE ONLY escuela.representante
    ADD CONSTRAINT representante_pkey PRIMARY KEY (id_representante);
 K   ALTER TABLE ONLY escuela.representante DROP CONSTRAINT representante_pkey;
       escuela            emilio    false    235            �           2606    17755    roles roles_pkey 
   CONSTRAINT     S   ALTER TABLE ONLY escuela.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id_rol);
 ;   ALTER TABLE ONLY escuela.roles DROP CONSTRAINT roles_pkey;
       escuela            emilio    false    259            �           2606    16657    usuarios usuarios_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY escuela.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id_usuario);
 A   ALTER TABLE ONLY escuela.usuarios DROP CONSTRAINT usuarios_pkey;
       escuela            emilio    false    221            �           2606    16659    usuarios usuarios_username_key 
   CONSTRAINT     ^   ALTER TABLE ONLY escuela.usuarios
    ADD CONSTRAINT usuarios_username_key UNIQUE (username);
 I   ALTER TABLE ONLY escuela.usuarios DROP CONSTRAINT usuarios_username_key;
       escuela            emilio    false    221            �           2606    17718    blog blog_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.blog
    ADD CONSTRAINT blog_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.blog DROP CONSTRAINT blog_pkey;
       public            emilio    false    251            �           2606    17727    comunicados comunicados_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.comunicados
    ADD CONSTRAINT comunicados_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.comunicados DROP CONSTRAINT comunicados_pkey;
       public            emilio    false    253            �           2606    17743    fotos fotos_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.fotos
    ADD CONSTRAINT fotos_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.fotos DROP CONSTRAINT fotos_pkey;
       public            emilio    false    257            �           2606    17736    galeria galeria_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.galeria
    ADD CONSTRAINT galeria_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.galeria DROP CONSTRAINT galeria_pkey;
       public            emilio    false    255            �           2606    17691    nosotros nosotros_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.nosotros
    ADD CONSTRAINT nosotros_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.nosotros DROP CONSTRAINT nosotros_pkey;
       public            emilio    false    245            �           2606    17663    padres padres_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.padres
    ADD CONSTRAINT padres_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.padres DROP CONSTRAINT padres_pkey;
       public            emilio    false    241            �           2606    17709    profesor profesor_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.profesor
    ADD CONSTRAINT profesor_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.profesor DROP CONSTRAINT profesor_pkey;
       public            emilio    false    249            �           2606    17700    proyectos proyectos_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.proyectos
    ADD CONSTRAINT proyectos_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.proyectos DROP CONSTRAINT proyectos_pkey;
       public            emilio    false    247            �           2606    17681    tarjetas tarjetas_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.tarjetas
    ADD CONSTRAINT tarjetas_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.tarjetas DROP CONSTRAINT tarjetas_pkey;
       public            emilio    false    243            �           2606    17139 *   asignaciones asignaciones_id_paralelo_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY escuela.asignaciones
    ADD CONSTRAINT asignaciones_id_paralelo_fkey FOREIGN KEY (id_paralelo) REFERENCES escuela.paralelos(id_paralelo);
 U   ALTER TABLE ONLY escuela.asignaciones DROP CONSTRAINT asignaciones_id_paralelo_fkey;
       escuela          emilio    false    216    225    4817            	           2606    17462 (   asistencia asistencia_id_estudiante_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY escuela.asistencia
    ADD CONSTRAINT asistencia_id_estudiante_fkey FOREIGN KEY (id_estudiante) REFERENCES escuela.estudiantes(id_estudiante);
 S   ALTER TABLE ONLY escuela.asistencia DROP CONSTRAINT asistencia_id_estudiante_fkey;
       escuela          emilio    false    239    4833    231                        2606    17300 %   estudiantes estudiantes_id_madre_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY escuela.estudiantes
    ADD CONSTRAINT estudiantes_id_madre_fkey FOREIGN KEY (id_madre) REFERENCES escuela.madre_familia(id_madre);
 P   ALTER TABLE ONLY escuela.estudiantes DROP CONSTRAINT estudiantes_id_madre_fkey;
       escuela          emilio    false    231    4831    229                       2606    17295 %   estudiantes estudiantes_id_padre_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY escuela.estudiantes
    ADD CONSTRAINT estudiantes_id_padre_fkey FOREIGN KEY (id_padre) REFERENCES escuela.padre_familia(id_padre);
 P   ALTER TABLE ONLY escuela.estudiantes DROP CONSTRAINT estudiantes_id_padre_fkey;
       escuela          emilio    false    227    231    4829                       2606    17285 (   estudiantes estudiantes_id_paralelo_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY escuela.estudiantes
    ADD CONSTRAINT estudiantes_id_paralelo_fkey FOREIGN KEY (id_paralelo) REFERENCES escuela.paralelos(id_paralelo);
 S   ALTER TABLE ONLY escuela.estudiantes DROP CONSTRAINT estudiantes_id_paralelo_fkey;
       escuela          emilio    false    216    231    4817                       2606    17290 '   estudiantes estudiantes_id_periodo_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY escuela.estudiantes
    ADD CONSTRAINT estudiantes_id_periodo_fkey FOREIGN KEY (id_periodo) REFERENCES escuela.periodos_lectivos(id_periodo);
 R   ALTER TABLE ONLY escuela.estudiantes DROP CONSTRAINT estudiantes_id_periodo_fkey;
       escuela          emilio    false    218    4819    231            �           2606    17756    usuarios fk_rol    FK CONSTRAINT     s   ALTER TABLE ONLY escuela.usuarios
    ADD CONSTRAINT fk_rol FOREIGN KEY (id_rol) REFERENCES escuela.roles(id_rol);
 :   ALTER TABLE ONLY escuela.usuarios DROP CONSTRAINT fk_rol;
       escuela          emilio    false    4861    259    221                       2606    17339 (   matriculas matriculas_id_estudiante_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY escuela.matriculas
    ADD CONSTRAINT matriculas_id_estudiante_fkey FOREIGN KEY (id_estudiante) REFERENCES escuela.estudiantes(id_estudiante);
 S   ALTER TABLE ONLY escuela.matriculas DROP CONSTRAINT matriculas_id_estudiante_fkey;
       escuela          emilio    false    233    4833    231                       2606    17349 &   matriculas matriculas_id_paralelo_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY escuela.matriculas
    ADD CONSTRAINT matriculas_id_paralelo_fkey FOREIGN KEY (id_paralelo) REFERENCES escuela.paralelos(id_paralelo);
 Q   ALTER TABLE ONLY escuela.matriculas DROP CONSTRAINT matriculas_id_paralelo_fkey;
       escuela          emilio    false    216    233    4817                       2606    17344 %   matriculas matriculas_id_periodo_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY escuela.matriculas
    ADD CONSTRAINT matriculas_id_periodo_fkey FOREIGN KEY (id_periodo) REFERENCES escuela.periodos_lectivos(id_periodo);
 P   ALTER TABLE ONLY escuela.matriculas DROP CONSTRAINT matriculas_id_periodo_fkey;
       escuela          emilio    false    233    218    4819                       2606    17450 &   profesores profesores_id_paralelo_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY escuela.profesores
    ADD CONSTRAINT profesores_id_paralelo_fkey FOREIGN KEY (id_paralelo) REFERENCES escuela.paralelos(id_paralelo);
 Q   ALTER TABLE ONLY escuela.profesores DROP CONSTRAINT profesores_id_paralelo_fkey;
       escuela          emilio    false    4817    216    237                       2606    17445 %   profesores profesores_id_periodo_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY escuela.profesores
    ADD CONSTRAINT profesores_id_periodo_fkey FOREIGN KEY (id_periodo) REFERENCES escuela.periodos_lectivos(id_periodo);
 P   ALTER TABLE ONLY escuela.profesores DROP CONSTRAINT profesores_id_periodo_fkey;
       escuela          emilio    false    218    237    4819            
           2606    17744    fotos fotos_galeria_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.fotos
    ADD CONSTRAINT fotos_galeria_id_fkey FOREIGN KEY (galeria_id) REFERENCES public.galeria(id) ON DELETE CASCADE;
 E   ALTER TABLE ONLY public.fotos DROP CONSTRAINT fotos_galeria_id_fkey;
       public          emilio    false    257    4857    255            �   4   x���	  ��s�q�/�_����#Ƹ)��5[����IDM���C�Hz��      �   �   x�u�I�0@ѵ{����x��[���	Z�n��O��A%�EKA5X��}y,��2e�x��/R��*���Dm]4��%ēh�V'��t������0>E��L(�Jv���e���4'������C� ƛ�[��=�����#�oy� �0گ�.�3%��ⷕ���5(�$[��c���Q�zG���|9��?��4M�V?��      �   �  x�m�Mn�0���S� �AR��RҴ���	�U6�qhФCI��t�s�bZ�l'��E~��<� ���iV	�~�V��4|��xPB�&RN���^�"l�����M��[����8��v:<��Fow��t�٭A)�	��8XR%�4ˋR��w����>���?A�B*��CK��D�(�ggZ��_�:�}���TX��Tʝ5{Z�x��r)x�y��]v�C�?��g �8�A�"�E��%YZ㨾��Qy�CN�Rm�X�L��7|�=��)1`o�����b�d����t�b���Q_9)���9J�j����/�q+�C�i�R#'�b�F�+OIno��U���l�H'4���N���Q
�]��Ѕ31Iܤ�����5Q�6��֓�:x^�ֻc�����~���3�s=a!��DH�6�>`L]��1z�q8�VN��V�K56��w���Sz���̙T'���5�����Ic��hP?�z�K��x�h;^��=��%]�������0ԃ[�5R �T������QJB/��W2ڎ���> ����1����IE��O�/�rA7Q."C
F�GB����o:�f�iK�_k;dLƌU�'�I�}�q9R2�o�0f�Sk��$S�T����,�%�8R��)c�*�n,      �   �  x���Kn�0���)x�"��UM�)\t��D�*(Ѡd��m�̢���J=�Ȧk���|3�?AJVz�rF�\�Q��YH*(�@)�A�eiG�౽�������A�U��"[4?�����H��ޖ^�����]���Ӏ:��Qa=�z*����tC�*����4��4`t�4/u�jrw|�Ȣ{���Ђ��"�V8f���v�~��66��$�c-7@��>6H�=Ю��h�\U���	��ǃ���N����1������v��u	�Ӫ{�Wc���8I>� �����K�;�m]ڳ� 3������dSZ��m��� �eMvsM��Ԃ�Vx&��Gh�<��bGg�&�%a�L6~b$��"]�&�k�br���Z���Pof�t�|���BR�:��`�+w�;F�Mv9�ΘC
�I��̉�[��h�d)���ш�<{q!��]����<�lӄA      �   F   x�5���0��QLd�`���_G�:�V���:�d"��+�h�}�eᥕf���ѯ[�0�&�{D��      �   �  x���M��0���S��@�n(�毜̔���F���&�M�9�\,�&Ί2������c�K�����i4	X����"{�FBi]u�Mb��1T�Vkc���+������{Ն����u1������Q{���ǩ=<neE���9�~��(���d��H��OI�HZ�Mm�*T����6�8��a$��
����z�hAM�
��vgW�#�Zl���*\��qOA��qki��!�R�s�k��}��^�ȝ�_�͂ �6w��"�Y�n ����U��rL_'��=!�p�s�����h1]�-G�罖�Q_,.�z��Ì�։� nO�G�
�	��!�0��5�j�f�{��N�i�=��8.��S�0�8�MDC�F����P��Yp���������]_�|G�-�)���b"7N��a�4:#��r�]w^$�j[��ᰙO㬻��ֈ����h\Lsd�DW{a�?zg�D4��'W{y�f��_���8      �   $   x�32����L�L�Q��22Fp�<S$�'W� 7�S      �   ^   x�M���0k�"��X� eR������+7�$�N�������)4I�(�hWFYT�P�i�B<UD!8�ꑫ�&���Ě�u�vf��h�      �   M   x�����IO�S��,N-Q�44���24���L�S��/NU�)�,�44�[��}�����y�
��E9�P�=... ��      �   �  x����n�0�ׇ��P0�]�T�%i�V]es<�'#Ì�y�.��b5�+�f���;�~`pk*��G�
!�I�1w�xE��Eg�hS�(�@�U�)���*���F؅�D,E�hCB�H���^��f�W�y޾[G�_aMfh�i]r��<
3�Z�ӒoZ�����>a����Ҵ���Z�Z	k�L�����nkXҁ�qn�ot{�����Z�z!ܢ-���Z��n#�빰E:�6n�B>7KsX:�b��t~yD0�\	}���
m�$������N(	Tä�9���g=��/�[���<:@4r~lߛNUH8��l�B���1!�����C�9�U�
��|��w3x��A�#��_��v7�.bZWr����#i񩴐����{����Hs�%֥=җ��i<�/���l��Vj�cKGؓY�IF��Q ������v��_�(��_����1v������rS=E����X�"v�TJ�˦8�����/��y� �ݚL      �   3   x�3�L-.)M�L�+I�2�,(�OK-�/�2�LL����,.)JL�c���� _c�      �   �   x�5�;�0  й=sC��V0�T�ј��P��HA�퍃� ��d�k1��6�]�-�j�nO����g�!kk_J��1�ܟT�]��t�H�_%��O�J5�\���]�v��;	���t���H���fU8#ng��:�9,��8�-�      �     x�}W�n9<�_A�,��v�	`�k`A�P3�19!����~��>�[��c[��(?r0$ͣ�Y]U�~���v�W���+r�j��M�n��í>:��1xՐ�⛣�{5�0�&Y�����}蒵Ԑj|?��H�o5^�mC�\c�ҍn���4z�>x7�<�����^����>PT�����ښ���Q}O�"���D�N;5����`'�/Y��G�x��1�F�T����\ P{��9����]�Ǭ�|��H��� 5܎��i�;Q���� A䚺�[cM�q[5a:>��^[9��+�x��ͷ������O<:��%c5������j� Đ�c����)ju7��%8�g�|� >�H���w�Q�#4����uLx���h�F��b#i�Y���tPz&H�D(�B�=@�Á ��+�Ñw��A��MG�OM�~�|�Lf��x�� ��}	��1-����(�%��?_�X�����@�8�ME{o�BZ����_on�������K��dkX?_��*jO�!��[`S�1B���/wrP�(Q�?�@��y�rh`�T�Q�2H3?�0�N��-��nאh`��,�LwϨ�O��Y=J���K���/�G��,��<�ՙ�N��f�^"����M25ArzQ�{�Z�I���0�����%�h:�ܚ����_��V� ��-� �iL��1�ee3FPg��i�Fh�vu<*�sc��B�!4k���V�t�@��$z�s�-�C�u�@E�V2�oKz:����~����It.�.8��aƊI�Q�I2{�L�-.S����'�9��7���v�|q]�9���Y�����*��cP&|2����r�L�8B&��$�
�ø{�X���Qa��<b�HY&L:��L���(�Z�W*�[b[�l��1
�6�cd���d�$�r�D#,�� >��-+��19S� ka�
�D,�.}d���?XT//J��G�������`�i��;� X֊�Y�_<���p*7)^�W��PU�B����s��t�(�Ċ#�b�z�_'Zy�*���,�mN���E�lɍ�mn�u�sG��Ƚ�x-&�A�eH.T��#c�[D]*���V�g^�;�/���z�AI�vp���\��)q��UM��d��|B�ic.��'�KQ�V���F�k���`Y'��O n E�p�:�,���`>�co���	�܇z�9g����qrBX;��Ȗ�+�W�\d�Nd�~���
�9
��9)�_��dk�qU�(����r�K���Ѩ69>��ӎ��б��u�e!�}|Y+2���(f;b6k:gkU���Y�Á'P©�����y3�{=�����fY��:E���qN������L䞶"o(��W�L��� ��}�7�k�S�3�,�@���T��x��Z�Y٪=:��̃�Э��Y��� �l���#�<�u��XV�<~\-����ӭ��H���Q�y�^x�msqq�?�YR�      �   �  x��V�n#G���\L�ہ#C'G�ـS%��&5����<��?E��>a��=�$u:��3�����o�nd�>��$�@�������tu݇_)��]���ܟ���a�d�QҮ����Bɢ���s�����v�K��(8l��^׳�\ٕDz��|�(f�nGJ�b-�'-�-��$�qz����q.���kw�����4̑4"X9�׃{īݽ�az��������I���E~r�j,�K[I:���{�W�^�a�+7=�a����Z��h]p�&6���δ�^��:�؋��T
�t��SEKI��h��Q4r���v����e?�.��H�u�%��B��c�t
J֖
>�>=%���@�����8w$z$�>�?�?��q�>�}D�D�ّx��CcO�j��k�����g;�8�$!��i㱋��]�S���, l�v?��8Q��Nnj�L%�������y@���Z(��ӳ��n���������G��4�j�)����窋5j�ZZ�IQ�W~�}�~w��^}��0�{n$�P[��֝��0O�ofI�����Gp4��Z�gU4) ����p�� �7T�fd���o1y��e i�p�6 e�|�i�0�j��l,`�9r��C[<�7ҔMwJ_�T�n�PӅ0~i��V�j�8�$_���q�\k��bY%�rI1鞨F��%�v����d��d�(������hDX����`��Z�f� �.�g+�И+إ:jΕ^�QL���c�/$o��^٦+i>�zZ�jdt� 56%4���26�.�w��+��h� %p"ӓ^g���Z�ی��y��ȑ���]\���E��hc�Gӻ�iC�z7�l#�䡰�`�E�ϕ����7�`:���7���M����Q��g9�lZ�\�B��S��D����m��ڿ&����\Tm����alS�����f̭i��,�:�yq���9��\-A�f��U�H���Q�0�|M�r��T&U|x7�4�X��x�'!߼�*NMİ��2;hz�^j|���ҵ]U�/��r{��[c��t�j�-�vh�h�����-	�����������Ķ�ޤ�����c��8�:�;��lm��gH]f/����{�z� ଴r΃W!SW���-�@��18�
~����߲�˻�yv�� ��gUt4"���o��e~mk����M�w���� f`�      �   K   x�3�4�,-��OL)�OO�I-�L�7��*H��"c���"c�14�"e�2�"e
�2�"e�2�4�!���� �";�      �   2   x�3�(ʯLM.�W�������M�+�/V@�2�����(�!�=... b#      �   >  x�5��N1���SX���� �J�k_����8���<#bc�ù������Ϲ�^�`[B%A8�!L����-�6���_ce�"��d�d-@Ym�"
4��.�]G�&R�Ͽ8O4
\Z/�p��Óf���e�X.�A�t2M\ԗ?*�y�Ah"T���Q�4�I-�5�e�\�Ņ�3�P�p5�aW�L�)���A-�������P'���oX.��Z�ٱ�7��A�-xI�q�Fޠ�ܼ���t�Ƈ�x�At�_*xL��7&��<SA3����/�Heo�������4ɯ�      �   b   x�%�;
�0E�z��YA��lK���`�wTܾA�۝���M��s5��H"��;F�i���>o4�ǉ��<��Wh+�Q��g8���ߵh���!$7      �   �   x�U�1� ��N�	�PRv�M]]^"��4�ǳx1IXt���7옼�)�8��R��ce�T�ߨ j4�''�������y����J��h`��˖�<�Q6rK��	m�c�� `T'�9��A1      �     x�]T���F�w���x���̡� @�]�;���bv������`�
t��2���K\=$O{�!�=��U����g���)n��Y3��$�U	Lg����{�M�Hr5��8���*�,�q�,i��+uBi��>j���شW4QM�-L2S�Cr�v����̱S�&��3#$��H��D$���gF�DBn����;��䑍��ɷ�L%�8��>t��N��ӿL�*�>G��O��M�ў��ސ��G���cg�5:���$��񀟨	�8�G�U6��ϵ��;����	Ta��g��w��A(] �h�ĭ8(>N�ۛ����t��w�U���=�m��!�� R�������fz�]�\�����cu�̭�,� �ع�v�Pk٢�ȡ�f;�S���O�+��TxRр^!���D���u$:��+~��kO4{�q���#�ӧ,�f��ˏ�G>�/t�� �8�#sY+���� WTZ�G�u�*I��؅����,��4y��'�g�����h�-sr%�m���MZ1��7�:��uc��	����ǫ"���&�YB�u����鯾����>Hz��-�qNS�M�f��r�_RYҧ�^]�	�?�������`~��ȡ9�~�y*:9������fkvM���6��b�D+�O��~}�7�Գ�'��T��]��,j9S�#�����r����p��.Mņ삫ł�ߊ����ĩ��a:Һ�<��4��:�KM�vE���O\�c�1���a9��v��W���ɗ������;����~���ߚ3�      �   <  x�mS�n�@��� \�j���l�@�4�w=����.��rWۥՏ�qV�A��w�]w��F���b>�&�T�Գ�j��D��%;�j����RGˡ�g�2J���)E�8�o��#�F>��8�OIП�)Gc��_����6ՂwgS�v&1I�q�<��뚭a4|a븻b�˟�$�6�
&�8).t���*0���m|�B2V���@߷�$����z>s��|�Abc�C �p8�̅�T�Yc���Q`,�3e��C���h���C�U��[�
����� t*��e�O��O��$�ߤ�n�_�#����r�����%q3��k�kSZ��Ѩ���� )�C����"8L@��~��[z��)Egtc��+ !jy�3��j�1�Ľ�~�<��o0�O���XaqG��ή�}���H���p��tvNA�^�Hiй��I�cK�VXg�c3�:��5D�i7�G��ݥ���7��&�<����M2�n9�T�,�hn��˾ı��SR�� �����=�2�� W�1���vy�[��((�3�ׂ�~y~�*G��������ֱ��     