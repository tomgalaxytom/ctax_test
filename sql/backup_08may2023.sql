--
-- PostgreSQL database dump
--

-- Dumped from database version 14.5
-- Dumped by pg_dump version 14.5

-- Started on 2023-05-08 17:23:04

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 5 (class 2615 OID 44909)
-- Name: mybillmyright; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA mybillmyright;


ALTER SCHEMA mybillmyright OWNER TO postgres;

--
-- TOC entry 271 (class 1255 OID 44910)
-- Name: fn_assigned_usercharge_jsondata(character varying, character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.fn_assigned_usercharge_jsondata(_roletypecode character varying, _divisioncode character varying, _zonecode character varying, _distcode character varying, _circleid integer, _session_userid integer) RETURNS json
    LANGUAGE plpgsql
    AS $$
declare

		json_data json;

		_return_or_fwd_or_all character varying;

	BEGIN

	
	 SET search_path to mybillmyright;

	 json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (
		 
		  select u.name,u.empid,d.divisionsname,d.divisionlname,dist.distename,z.zonesname,z.zonelname,c.circlename,ch.chargedescription,r.roletypelname,ra.roleactionlname  from 
 			mst_user_charge uc
 
			JOIN mst_dept_user u ON uc.userid = u.userid
			JOIN mst_roletype r ON r.roletypecode = u.roletypecode

			JOIN mst_charge ch ON ch.chargeid = uc.chargeid
			JOIN mst_roleaction ra ON ra.roleactioncode = ch.roleactioncode
			LEFT JOIN mst_division d ON d.divisioncode::text = u.divisioncode::text
			LEFT JOIN mst_district dist ON u.distcode::text = dist.distcode::text
			LEFT JOIN mst_zone z ON u.zonecode::text = z.zonecode::text
			LEFT JOIN mst_circle c ON u.circleid = c.circleid

		  WHERE (u.divisioncode=_divisioncode  or _divisioncode='A' ) and (u.distcode= _distcode or _distcode='A')
				and (u.zonecode= _zonecode or _zonecode='A') and (u.circleid=_circleid or _circleid=0)
				and u.userid <> _session_userid and		 		 
		 CASE
		 			WHEN _roletypecode = '01' THEN u.roletypecode <> '01'
					WHEN _roletypecode = '02' THEN u.roletypecode <> '01' AND u.roletypecode <> '02' 
					WHEN _roletypecode = '03' THEN u.roletypecode <> '01' AND u.roletypecode <>'02' AND u.roletypecode <> '03'
					WHEN _roletypecode = '04' THEN u.roletypecode <> '01' AND u.roletypecode <> '02' AND u.roletypecode <> '03' AND u.roletypecode <> '04'
		 End
				
	  ORDER BY ch.createdon DESC ) t) ;

		   return json_data;

	 End;
$$;


ALTER FUNCTION mybillmyright.fn_assigned_usercharge_jsondata(_roletypecode character varying, _divisioncode character varying, _zonecode character varying, _distcode character varying, _circleid integer, _session_userid integer) OWNER TO postgres;

--
-- TOC entry 280 (class 1255 OID 44911)
-- Name: fn_assigningcharge_jsondata(character varying, character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.fn_assigningcharge_jsondata(_roletypecode character varying, _divisioncode character varying, _zonecode character varying, _distcode character varying, _circleid integer, _session_userid integer) RETURNS json
    LANGUAGE plpgsql
    AS $$
declare

		json_data json;

		_return_or_fwd_or_all character varying;

	BEGIN

	
	 SET search_path to mybillmyright;

	 json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (
	

	SELECT DISTINCT 
		u.divisioncode,u.zonecode,u.distcode,u.circleid,uc.statusflag,ch.createdby,
		dist.distename,d.divisionlname,z.zonelname,c.circlename,u.name,
		u.userid,uc.statusflag AS status,u.profile_update,uc.createdon AS uc_createdon,u.roletypecode 

		FROM mst_charge ch

		JOIN mst_dept_user u ON u.roletypecode::text = ch.roletypecode::text
		LEFT JOIN mst_user_charge uc ON uc.userid = u.userid
		LEFT JOIN mst_division d ON d.divisioncode::text = u.divisioncode::text
		LEFT JOIN mst_district dist ON u.distcode::text = dist.distcode::text
		LEFT JOIN mst_zone z ON u.zonecode::text = z.zonecode::text
		LEFT JOIN mst_circle c ON u.circleid = c.circleid
		  WHERE (u.divisioncode=_divisioncode  or _divisioncode='A' ) and (u.distcode= _distcode or _distcode='A')
				and (u.zonecode= _zonecode or _zonecode='A') and (u.circleid=_circleid or _circleid=0)
				and u.userid <> _session_userid and uc.statusflag IS NULL and
				CASE
		 			WHEN ch.roletypecode = '02' THEN ch.circleid IS NULL AND u.userid IS NOT NULL AND uc.statusflag IS NULL
					WHEN ch.roletypecode = '04' THEN u.divisioncode::text = ch.divisioncode::text AND u.distcode::text = ch.distcode::text AND u.zonecode::text = ch.zonecode::text AND ch.circleid IS NULL AND u.userid IS NOT NULL AND uc.statusflag IS NULL
					WHEN ch.roletypecode = '03' THEN ch.zonecode IS NULL AND ch.circleid IS NULL AND u.divisioncode::text = ch.divisioncode::text AND u.userid IS NOT NULL AND uc.statusflag IS NULL
					WHEN ch.roletypecode = '05' THEN u.circleid::text = ch.circleid::text AND u.userid IS NOT NULL AND uc.statusflag IS NULL
		 			WHEN ch.roletypecode = '07' THEN u.circleid::text = ch.circleid::text AND u.userid IS NOT NULL AND uc.statusflag IS NULL

					ELSE NULL::boolean
				END
	  ORDER BY ch.createdby DESC ) t) ;

		   return json_data;

	 End;
$$;


ALTER FUNCTION mybillmyright.fn_assigningcharge_jsondata(_roletypecode character varying, _divisioncode character varying, _zonecode character varying, _distcode character varying, _circleid integer, _session_userid integer) OWNER TO postgres;

--
-- TOC entry 281 (class 1255 OID 44912)
-- Name: fn_chargedetails_jsondata(character varying, character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.fn_chargedetails_jsondata(_roletypecode character varying, _divisioncode character varying, _zonecode character varying, _circleid integer, _distcode character varying, _session_chargeid integer) RETURNS json
    LANGUAGE plpgsql
    AS $$
declare

		json_data json;

	BEGIN

	 SET search_path to mybillmyright;

	 json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (

		select dd.distename,c.circlename,u.chargedescription, 
		 
           u.createdon,d.divisioncode,r.roletypelname,d.divisionlname,z.zonelname,dd.distename,c.circlename,
		 
		    u.zonecode,u.chargeid

 from mst_charge u

left join mst_division d on d.divisioncode =u.divisioncode 

left join mst_zone z on u.zonecode = z.zonecode 
		 
left join mst_district dd on dd.distcode = u.distcode 

left join mst_circle c on c.circleid	=	u.circleid 

inner join mst_roletype r on r.roletypecode = u.roletypecode 

where  (u.divisioncode=_divisioncode  or _divisioncode='A' ) and (u.distcode= _distcode or _distcode='A')

     and (u.zonecode= _zonecode or _zonecode='A')   and (u.circleid=_circleid or _circleid=0) and u.chargeid <> _session_chargeid 
		 
		and u.roletypecode <> '06' and
		 		 
		 CASE
		 			WHEN _roletypecode = '01' THEN u.roletypecode <> '01'
					WHEN _roletypecode = '02' THEN u.roletypecode <> '01' AND u.roletypecode <> '02' 
					WHEN _roletypecode = '03' THEN u.roletypecode <> '01' AND u.roletypecode <>'02' AND u.roletypecode <> '03'
					WHEN _roletypecode = '04' THEN u.roletypecode <> '01' AND u.roletypecode <> '02' AND u.roletypecode <> '03' AND u.roletypecode <> '04'
		 End

	  order by u.createdon DESC 

	 ) t) ;

		   return json_data;

	 End;
$$;


ALTER FUNCTION mybillmyright.fn_chargedetails_jsondata(_roletypecode character varying, _divisioncode character varying, _zonecode character varying, _circleid integer, _distcode character varying, _session_chargeid integer) OWNER TO postgres;

--
-- TOC entry 282 (class 1255 OID 44913)
-- Name: fn_deptuserdetails_jsondata(character varying, character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.fn_deptuserdetails_jsondata(_roletypecode character varying, _divisioncode character varying, _zonecode character varying, _circleid integer, _distcode character varying, _session_userid integer) RETURNS json
    LANGUAGE plpgsql
    AS $$
declare

		json_data json;

	BEGIN

	

	 SET search_path to mybillmyright;

	 json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (

		select dd.distename,c.circlename,u.email,u.name,u.mobilenumber, 
		 
            u.userid,u.createdon,d.divisioncode,r.roletypelname,u.dateofbirth,d.divisionlname,z.zonelname,dd.distename,c.circlename,
		 
		    u.zonecode,u.circleid

 from mst_dept_user u

left join mst_division d on d.divisioncode =u.divisioncode 

left join mst_zone z on u.zonecode = z.zonecode 
		 
left join mst_district dd on dd.distcode = u.distcode 

left join mst_circle c on c.circleid	=	u.circleid 

inner join mst_roletype r on r.roletypecode = u.roletypecode 

where  (u.divisioncode=_divisioncode  or _divisioncode='A' ) and (u.distcode= _distcode or _distcode='A')

     and (u.zonecode= _zonecode or _zonecode='A')   and (u.circleid=_circleid or _circleid=0) and u.userid <> _session_userid 
		 
		 and u.roletypecode <> '06' and
		 		 
		 CASE
		 			WHEN _roletypecode = '01' THEN u.roletypecode <> '01'
					WHEN _roletypecode = '02' THEN u.roletypecode <> '01' AND u.roletypecode <> '02' 
					WHEN _roletypecode = '03' THEN u.roletypecode <> '01' AND u.roletypecode <>'02' AND u.roletypecode <> '03'
					WHEN _roletypecode = '04' THEN u.roletypecode <> '01' AND u.roletypecode <> '02' AND u.roletypecode <> '03' AND u.roletypecode <> '04'
		 End

	  order by u.createdon DESC 

	 ) t) ;

		   return json_data;

	 End;
$$;


ALTER FUNCTION mybillmyright.fn_deptuserdetails_jsondata(_roletypecode character varying, _divisioncode character varying, _zonecode character varying, _circleid integer, _distcode character varying, _session_userid integer) OWNER TO postgres;

--
-- TOC entry 272 (class 1255 OID 44914)
-- Name: fn_get_dashboardabstract_citizendet(character varying, character varying, character varying, character varying, integer); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.fn_get_dashboardabstract_citizendet(_roletypecode character varying, _divisioncode character varying, _distcode character varying, _zonecode character varying, _circeid integer) RETURNS json
    LANGUAGE plpgsql
    AS $$
declare

	_citizen_count integer;

	_billuploaded_count integer;

	

	json_data json;

	BEGIN

        SET search_path to mybillmyright;

        SELECT count(*) into _citizen_count From mst_user where  

         (distcode= _distcode or _distcode='A')

            ;
		
		SELECT  count(*) into _billuploaded_count From billdetail where

         (distcode= _distcode or _distcode='A')

            ;

     

            json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (

                SELECT _citizen_count as citizen_count,_billuploaded_count as billuploaded_count) t) ;

       

          
  return json_data;
	 End;
$$;


ALTER FUNCTION mybillmyright.fn_get_dashboardabstract_citizendet(_roletypecode character varying, _divisioncode character varying, _distcode character varying, _zonecode character varying, _circeid integer) OWNER TO postgres;

--
-- TOC entry 273 (class 1255 OID 44915)
-- Name: fn_get_dashboardabstract_deptuser(character varying, character varying, character varying, character varying, integer); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.fn_get_dashboardabstract_deptuser(_roletypecode character varying, _divisioncode character varying, _distcode character varying, _zonecode character varying, _circeid integer) RETURNS json
    LANGUAGE plpgsql
    AS $$
declare

	_created_user integer;

	_created_charge integer;

	_assigned_charge integer;

	json_data json;

	BEGIN

        SET search_path to mybillmyright;

        SELECT count(*) into _created_user From mst_dept_user where  

            (divisioncode=_divisioncode  or _divisioncode='A' ) and (distcode= _distcode or _distcode='A')

             and (zonecode= _zonecode or _zonecode='A')  and (circleid=_circeid or _circeid=0);
		
		SELECT  count(chargeid) into _created_charge From mst_charge where

           (divisioncode=_divisioncode  or _divisioncode='A' ) and (distcode= _distcode or _distcode='A')

             and (zonecode= _zonecode or _zonecode='A')  and (circleid=_circeid or _circeid=0);

        SELECT count(*) into _assigned_charge From mst_user_charge where 

             (divisioncode=_divisioncode  or _divisioncode='A' ) and (distcode= _distcode or _distcode='A')

             and (zonecode= _zonecode or _zonecode='A')  and (circleid=_circeid or _circeid=0);
		

     
	

            json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (

                SELECT _created_user as created_user,_created_charge as created_charge, 

                _assigned_charge as assigned_charge ) t) ;

       

          
  return json_data;
	 End;
$$;


ALTER FUNCTION mybillmyright.fn_get_dashboardabstract_deptuser(_roletypecode character varying, _divisioncode character varying, _distcode character varying, _zonecode character varying, _circeid integer) OWNER TO postgres;

--
-- TOC entry 274 (class 1255 OID 44916)
-- Name: fn_get_dashboarddescription_deptuser(character varying, character varying, character varying, character varying, integer, character varying); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.fn_get_dashboarddescription_deptuser(_roletypecode character varying, _divisioncode character varying, _distcode character varying, _zonecode character varying, _circleid integer, _data_name character varying) RETURNS json
    LANGUAGE plpgsql
    AS $$
declare

	json_data json;

	BEGIN

		SET search_path to mybillmyright;

        If (_data_name = 'create_user') then 
		
		    json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (

                select u.name,u.empid,d.divisionsname,d.divisionlname,dist.distename,z.zonesname, u.dateofbirth, u.mobilenumber,u.email,
                        z.zonelname,c.circlename,ch.chargedescription,r.roletypelname,ra.roleactionlname,d.divisioncode  from 
                    mst_user_charge uc
        
                    JOIN mst_dept_user u ON uc.userid = u.userid
                    JOIN mst_roletype r ON r.roletypecode = u.roletypecode
                    JOIN mst_charge ch ON ch.chargeid = uc.chargeid
                    JOIN mst_roleaction ra ON ra.roleactioncode = ch.roleactioncode
                    LEFT JOIN mst_division d ON d.divisioncode::text = u.divisioncode::text
                    LEFT JOIN mst_district dist ON u.distcode::text = dist.distcode::text
                    LEFT JOIN mst_zone z ON u.zonecode::text = z.zonecode::text
                    LEFT JOIN mst_circle c  ON u.circleid = c.circleid

                WHERE (u.divisioncode=_divisioncode  or _divisioncode='A' ) and (u.distcode= _distcode or _distcode='A')
                    and (u.zonecode= _zonecode or _zonecode='A') and (u.circleid=_circleid or _circleid=0)  
                    ) t) ; 
				
		ElseIf (_data_name = 'create_charge') then 
		
            json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (

                select dd.distename,c.circlename,u.chargedescription, u.createdon,d.divisioncode,r.roletypelname,
                
                    d.divisionlname,z.zonelname,dd.distename,c.circlename,u.zonecode,u.chargeid

                from mst_charge u

                left join mst_division d on d.divisioncode =u.divisioncode 

                left join mst_zone z on u.zonecode = z.zonecode 
                        
                left join mst_district dd on dd.distcode = u.distcode 

                left join mst_circle c on c.circleid	=	u.circleid 

                inner join mst_roletype r on r.roletypecode = u.roletypecode 

                where  (u.divisioncode=_divisioncode  or _divisioncode='A' ) and (u.distcode= _distcode or _distcode='A')

                    and (u.zonecode= _zonecode or _zonecode='A')   and (u.circleid=_circleid or _circleid=0)  
                        
                    and u.roletypecode <> '06'

                    ) t) ; 

        ElseIf(_data_name = 'assigned_charge')then

            json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (
            
            select u.name,u.empid,d.divisionsname,d.divisionlname,dist.distename,z.zonesname,z.zonelname,c.circlename,ch.chargedescription,r.roletypelname,ra.roleactionlname  from 
                mst_user_charge uc
    
                JOIN mst_dept_user u ON uc.userid = u.userid
                JOIN mst_roletype r ON r.roletypecode = u.roletypecode

                JOIN mst_charge ch ON ch.chargeid = uc.chargeid
                JOIN mst_roleaction ra ON ra.roleactioncode = ch.roleactioncode
                LEFT JOIN mst_division d ON d.divisioncode::text = u.divisioncode::text
                LEFT JOIN mst_district dist ON u.distcode::text = dist.distcode::text
                LEFT JOIN mst_zone z ON u.zonecode::text = z.zonecode::text
                LEFT JOIN mst_circle c ON u.circleid = c.circleid

            WHERE (u.divisioncode=_divisioncode  or _divisioncode='A' ) and (u.distcode= _distcode or _distcode='A')
                    and (u.zonecode= _zonecode or _zonecode='A') and (u.circleid=_circleid or _circleid=0)
            ORDER BY ch.createdon DESC ) t) ;

        End if;

    return json_data;
	 End;
$$;


ALTER FUNCTION mybillmyright.fn_get_dashboarddescription_deptuser(_roletypecode character varying, _divisioncode character varying, _distcode character varying, _zonecode character varying, _circleid integer, _data_name character varying) OWNER TO postgres;

--
-- TOC entry 283 (class 1255 OID 44917)
-- Name: fn_get_role_menu_det_jsondata(integer, character varying); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.fn_get_role_menu_det_jsondata(_roleid integer, _menu character varying) RETURNS json
    LANGUAGE plpgsql
    AS $$
declare

		json_data json;

		_fwdto_action_code integer;

	BEGIN

        SET search_path to mst_menu_mapping;

		if _menu='Y' then 

            json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (

            SELECT menuname,key from mybillmyright.mst_menu_mapping

            LEFT JOIN jsonb_array_elements_text((control_json -> '1') ) as config

            ON TRUE

            LEFT JOIN mybillmyright.mst_menu ON  (config) = mybillmyright.mst_menu.menuid ::text  where (mst_menu_mapping.roleid=_roleid  or _roleid=0 )

             ) t) ;

	  elseif _menu='N' then 

        json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (

	  	SELECT distinct(role_data.roleid),rolesname,rolelname,role_data.status from mybillmyright.mst_menu_mapping

        LEFT JOIN jsonb_array_elements_text((control_json -> '1') ) as config

        ON TRUE

        LEFT JOIN mybillmyright.mst_menu ON  (config) = mybillmyright.mst_menu.menuid ::text

        LEFT JOIN mybillmyright.mst_role role_data ON role_data.roleid = mybillmyright.mst_menu_mapping.roleid 

        where (role_data.roleid=_roleid  or _roleid=0 )  ) t) ;

	End if;

	 return json_data;

	 End;
$$;


ALTER FUNCTION mybillmyright.fn_get_role_menu_det_jsondata(_roleid integer, _menu character varying) OWNER TO postgres;

--
-- TOC entry 284 (class 1255 OID 44918)
-- Name: fn_get_rolepermission(integer); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.fn_get_rolepermission(_charge_id integer) RETURNS json
    LANGUAGE plpgsql
    AS $$

declare

		json_data json;

	BEGIN

        SET search_path to mybillmyright;

            json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (

            SELECT control_json -> '1' AS control_json FROM mst_menu_mapping

                inner JOIN mst_charge charge ON  charge.roleid = mst_menu_mapping.roleid 

             where (chargeid=_charge_id  or _charge_id=0 )

             ) t) ;

	 return json_data;

	 End;

$$;


ALTER FUNCTION mybillmyright.fn_get_rolepermission(_charge_id integer) OWNER TO postgres;

--
-- TOC entry 285 (class 1255 OID 44919)
-- Name: fn_getcharge_basedon_roleid(integer, character varying, character varying, integer, character varying); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.fn_getcharge_basedon_roleid(_roleid integer, _divisioncode character varying, _zonecode character varying, _circleid integer, _distcode character varying) RETURNS json
    LANGUAGE plpgsql
    AS $$
declare

		json_data json;

		_return_or_fwd_or_all character varying;

	BEGIN

	
	 SET search_path to mybillmyright;

	 json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (

select * from mst_charge a

where  (a.divisioncode=_divisioncode  or _divisioncode='A' ) 
		 
		 and (a.zonecode= _zonecode or _zonecode='A')
		 
		  and (a.circleid=_circleid or _circleid=0)

        and (a.distcode=_distcode or _distcode='A') and a.roleid=_roleid 

	  order by a.createdby DESC 

	 ) t) ;

		   return json_data;

	 End;
$$;


ALTER FUNCTION mybillmyright.fn_getcharge_basedon_roleid(_roleid integer, _divisioncode character varying, _zonecode character varying, _circleid integer, _distcode character varying) OWNER TO postgres;

--
-- TOC entry 286 (class 1255 OID 44920)
-- Name: fn_getcharge_basedon_roleid(character varying, character varying, character varying, integer, character varying); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.fn_getcharge_basedon_roleid(_roletypecode character varying, _divisioncode character varying, _zonecode character varying, _circleid integer, _distcode character varying) RETURNS json
    LANGUAGE plpgsql
    AS $$
declare

		json_data json;

		_return_or_fwd_or_all character varying;

	BEGIN

	
	 SET search_path to mybillmyright;

	 json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (

select * from mst_charge a

where  (a.divisioncode=_divisioncode  or _divisioncode='A' ) 
		 
		 and (a.zonecode= _zonecode or _zonecode='A')
		 
		  and (a.circleid=_circleid or _circleid=0)

        and (a.distcode=_distcode or _distcode='A') and a.roletypecode=_roletypecode 

	  order by a.createdby DESC 

	 ) t) ;

		   return json_data;

	 End;
$$;


ALTER FUNCTION mybillmyright.fn_getcharge_basedon_roleid(_roletypecode character varying, _divisioncode character varying, _zonecode character varying, _circleid integer, _distcode character varying) OWNER TO postgres;

--
-- TOC entry 275 (class 1255 OID 44921)
-- Name: fn_getspecificuser_allcharges_del(integer, integer); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.fn_getspecificuser_allcharges_del(_user_id integer, _charge_id integer) RETURNS json
    LANGUAGE plpgsql
    AS $$
declare

		json_data json;

		_return_or_fwd_or_all character varying;

	BEGIN

	
	 SET search_path to mybillmyright;

	 json_data:=(select  array_to_json(array_agg(row_to_json(t)))from (
		 
		  
		select u.name,u.empid,d.divisionsname,d.divisionlname,dist.distename,z.zonesname,z.zonelname,c.circlename,ch.chargedescription,r.roletypelname,ra.roleactionlname  
		  
		  ,u.userid,u.email,u.roletypecode,r.roletypelname,uc.createdon as usercharge_createdon
		  
		  from 	mst_user_charge uc
 
			JOIN mst_dept_user u ON uc.userid = u.userid
			JOIN mst_roletype r ON r.roletypecode = u.roletypecode

			JOIN mst_charge ch ON ch.chargeid = uc.chargeid
			JOIN mst_roleaction ra ON ra.roleactioncode = ch.roleactioncode
			LEFT JOIN mst_division d ON d.divisioncode::text = u.divisioncode::text
			LEFT JOIN mst_district dist ON u.distcode::text = dist.distcode::text
			LEFT JOIN mst_zone z ON u.zonecode::text = z.zonecode::text
			LEFT JOIN mst_circle c ON u.circleid = c.circleid

		  WHERE  u.userid	=	_user_id and    (ch.chargeid=_charge_id or _charge_id=0)		 
		
				
	  ORDER BY ch.createdon DESC ) t) ;

		   return json_data;

	 End;
$$;


ALTER FUNCTION mybillmyright.fn_getspecificuser_allcharges_del(_user_id integer, _charge_id integer) OWNER TO postgres;

--
-- TOC entry 276 (class 1255 OID 44923)
-- Name: forwardbillselection1(integer, character varying, integer, integer, character varying); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.forwardbillselection1(p_bill_selection_id integer, p_process_code character varying, p_forwarded_to integer, p_logged_in_userid integer, p_remarks character varying) RETURNS SETOF character varying
    LANGUAGE plpgsql COST 10
    AS $$
DECLARE

-- billdetailid integer;
-- userid integer;
-- configcode character varying;
-- mobilenumber character varying;
-- rowCount integer;
-- rec record;
-- rec1 record;
logged_in_user_role_action_code character varying;
v_forwardedto_role_action_code character varying;
v_bill_user_id integer;
count1 integer;
count2 integer;

--select * from billdetail

BEGIN

--SET SEED TO seedValue;
SELECT roletypecode INTO logged_in_user_role_action_code FROM mybillmyright.mst_dept_user WHERE userid=p_logged_in_userid ;
SELECT roletypecode  INTO v_forwardedto_role_action_code FROM mybillmyright.mst_dept_user WHERE userid=p_forwarded_to;
SELECT userid INTO v_bill_user_id FROM mybillmyright.bill_selection_details 
		WHERE bill_selection_id = p_bill_selection_id;

-- start tracking in transaction history table 
INSERT INTO mybillmyright.history_transactions(
	transno, bill_user_id, forwarded_by, forwarded_to, forwarded_on, process_code, forwardedby_role_action_code, forwardedto_role_action_code,remarks,bill_selection_id)
	VALUES ('RANDOMID', v_bill_user_id, p_logged_in_userid, p_forwarded_to, NOW(), p_process_code, logged_in_user_role_action_code, v_forwardedto_role_action_code,p_remarks,p_bill_selection_id);
-- ADC 
if( logged_in_user_role_action_code = '02') then
	SELECT COUNT(*) INTO count1 FROM mybillmyright.transaction_detail WHERE 
	bill_selection_id=p_bill_selection_id;
	SELECT COUNT(*) INTO count2 FROM mybillmyright.transaction_detail WHERE process_code = 'R' 
	AND forwarded_to = p_logged_in_userid;
	if( count1 = 0 ) then
		-- start inserting records
		INSERT INTO mybillmyright.transaction_detail(bill_user_id, transno, process_code, alloted_on, forwarded_to,  
		updated_by, updated_on, forwardedto_role_action_code, updatedby_role_action_code, bill_selection_id,remarks) 
		SELECT v_bill_user_id, 'randomid', 'F', NOW(),p_forwarded_to, p_logged_in_userid, NOW(), v_forwardedto_role_action_code, 
		logged_in_user_role_action_code, p_bill_selection_id,p_remarks FROM mybillmyright.bill_selection_details 
		WHERE bill_selection_id = p_bill_selection_id;
	end if;
	if( count1 > 0 AND count2 > 0) then
		UPDATE mybillmyright.transaction_detail SET process_code='F', forwarded_to = p_forwarded_to, updated_by = p_logged_in_userid, 
		updated_on = NOW(), forwardedto_role_action_code = v_forwardedto_role_action_code, 
		remarks = p_remarks ,
		updatedby_role_action_code = logged_in_user_role_action_code WHERE bill_selection_id = p_bill_selection_id AND process_code <> 'V';
	end if;
end if;
if( logged_in_user_role_action_code <> '02') then
	UPDATE mybillmyright.transaction_detail SET process_code=p_process_code, forwarded_to = p_forwarded_to, updated_by = p_logged_in_userid, 
		updated_on = NOW(), forwardedto_role_action_code = v_forwardedto_role_action_code, 
		remarks = p_remarks ,
		updatedby_role_action_code = logged_in_user_role_action_code WHERE bill_selection_id = p_bill_selection_id AND process_code <> 'V';

end if;

	return next 'success';
END

/*    
select mybillmyright.forwardBillSelection1(58,'F',4,3)
*/
$$;


ALTER FUNCTION mybillmyright.forwardbillselection1(p_bill_selection_id integer, p_process_code character varying, p_forwarded_to integer, p_logged_in_userid integer, p_remarks character varying) OWNER TO postgres;

--
-- TOC entry 277 (class 1255 OID 44924)
-- Name: getallotmentwinnerwithseed(character varying, character varying, numeric, character varying); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.getallotmentwinnerwithseed(distcode character varying, limitvalue character varying, seedvalue numeric, year_month character varying) RETURNS SETOF boolean
    LANGUAGE plpgsql COST 10
    AS $$
DECLARE

billdetailid integer;
userid integer;
configcode character varying;
mobilenumber character varying;
rowCount integer;
rec record;
rec1 record;

order_by_column integer;

--select * from billdetail

BEGIN
raise notice 'recwrk-----%',''||seedValue||'';
PERFORM  setseed(seedValue);
--SET SEED TO seedValue;

        for rec in execute 'SELECT billdetailid,userid, configcode, mobilenumber, acknumber,row_number() over (order by random()) FROM mybillmyright.billdetail where distcode='''||distcode||''' and
substring(acknumber,3,4)=
'''||year_month||'''  
limit '||limitValue||'' loop

--trans_id=rec.trans_id+1;
billdetailid = rec.billdetailid;
userid       = rec.userid;
configcode   = rec.configcode;
mobilenumber = rec.mobilenumber;
year_month   = substring(rec.acknumber,1,6) ;
order_by_column   = rec.row_number;
   
raise notice 'recwrk-----%',rec;

for rec1 in execute 'select count(*) from mybillmyright.bill_selection_details where billdetailid = '''||billdetailid||''' and  
userid = '''||userid||''' and distcode = '''||distcode||'''' loop

rowCount = rec1.count;

raise notice 'recCount-----%',rec1;

end loop;

if(rowCount = 0 ) then

INSERT INTO mybillmyright.bill_selection_details(billdetailid, userid, configcode, mobilenumber,
												 distcode, date_archived, p_status,year_month,seed_value,selection_value,order_by_column)
VALUES (billdetailid,userid, configcode, mobilenumber, distcode, now(), '0',year_month,seedValue,limitvalue,order_by_column);

end if ;

end loop;

END

/*    
select mybillmyright.getallotmentwinnerwithseed('569','3',0.33,'2304')
*/
$$;


ALTER FUNCTION mybillmyright.getallotmentwinnerwithseed(distcode character varying, limitvalue character varying, seedvalue numeric, year_month character varying) OWNER TO postgres;

--
-- TOC entry 287 (class 1255 OID 44925)
-- Name: getawknumber(character varying); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.getawknumber(distcode character varying) RETURNS SETOF record
    LANGUAGE plpgsql COST 10
    AS $$

DECLARE

	yearmonth character varying;
	deviceid character varying;
	mobilenumber character varying;
	rec record;
	rec1 record;
	
	
	--select * from billdetail

BEGIN

			
        for rec in execute 'SELECT concat(20,mc.yymm )  as yearmonth,mu.deviceid as deviceid ,mc.distcode as distcode,
            substring(mu.mobilenumber , 8) as mobilelastthreedigit
        FROM mybillmyright.mst_config as mc
        INNER JOIN mybillmyright.mst_user as mu
        ON mc.distcode = mu.distcode where mc.distcode = '''||distcode||''''
		loop

		--trans_id=rec.trans_id+1;
		yearmonth = rec.yearmonth;
		deviceid       = rec.deviceid;
		mobilenumber = rec.mobilelastthreedigit; 
		
		
		raise notice 'recwrk-----%',yearmonth;
	
	
		end loop; 
	
		for rec1 in select yearmonth , distcode ,deviceid,mobilenumber  loop		 	 
			 
	 	end loop; 
	 
		return next rec1;
END
	
/*   				  
	select * FROM mybillmyright.getAwkNumber('610') AS RECORD(yearmonth character varying,distcode character varying ,deviceid character varying,mobilenumber character varying);
*/
$$;


ALTER FUNCTION mybillmyright.getawknumber(distcode character varying) OWNER TO postgres;

--
-- TOC entry 278 (class 1255 OID 44926)
-- Name: getremarks(integer); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.getremarks(p_bill_selection_id integer) RETURNS SETOF record
    LANGUAGE plpgsql COST 10
    AS $$

DECLARE

	remarks character varying;
	rec record;
	rec1 record;
	
	
	
	--select * from billdetail

BEGIN

			
        for rec in execute 'SELECT ht.remarks
                from mybillmyright.transaction_detail td 
                inner join mybillmyright.history_transactions ht on  td.bill_selection_id = ht.bill_selection_id 
				where   td.bill_selection_id  = '''||p_bill_selection_id||''''
		loop

		--trans_id=rec.trans_id+1;
		remarks = rec.remarks;
		 
		
		
		raise notice 'recwrk-----%',rec;
	
	
		end loop; 
	
		for rec1 in select remarks,p_bill_selection_id  loop		 	 
			 return next rec1;
	 	end loop; 
	 
		
END
	
/*   				  
	select * FROM mybillmyright.getRemarks(430) AS RECORD(remarks character varying,p_bill_selection_id integer);
*/
$$;


ALTER FUNCTION mybillmyright.getremarks(p_bill_selection_id integer) OWNER TO postgres;

--
-- TOC entry 289 (class 1255 OID 44927)
-- Name: invoice_count_values(); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.invoice_count_values() RETURNS integer
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN (select count(*) from mybillmyright.mst_config where CURRENT_DATE between billentrystartdate and billentryenddate
);
END;
$$;


ALTER FUNCTION mybillmyright.invoice_count_values() OWNER TO postgres;

--
-- TOC entry 291 (class 1255 OID 45404)
-- Name: total_count_based_role_type_code1(character varying); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.total_count_based_role_type_code1(role_type_code character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$
declare 
total_no_rtc integer;
begin
if( role_type_code = '02' ) then
select count(*) into total_no_rtc from mybillmyright.bill_selection_details where p_status= '0';
end if;
if( role_type_code = '03' ) then
select count(*) into total_no_rtc from mybillmyright.bill_selection_details where p_status= '1';
end if;
if( role_type_code = '04' ) then
select count(*) into total_no_rtc from mybillmyright.bill_selection_details where p_status= '2';
end if;
if( role_type_code = '05' ) then
select count(*) into total_no_rtc from mybillmyright.bill_selection_details where p_status= '3';
end if;

return total_no_rtc;
end;
$$;


ALTER FUNCTION mybillmyright.total_count_based_role_type_code1(role_type_code character varying) OWNER TO postgres;

--
-- TOC entry 288 (class 1255 OID 45425)
-- Name: total_count_based_role_type_code2(character varying, character varying); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.total_count_based_role_type_code2(role_type_code character varying, p_distcode character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$
declare 
total_no_rtc integer;
begin
if( role_type_code = '02' ) then
select count(*) into total_no_rtc from mybillmyright.bill_selection_details where p_status= '0' and distcode='''||p_distcode||''';
end if;
if( role_type_code = '03' ) then
select count(*) into total_no_rtc from mybillmyright.bill_selection_details where p_status= '1' and distcode='''||p_distcode||''';
end if;
if( role_type_code = '04' ) then
select count(*) into total_no_rtc from mybillmyright.bill_selection_details where p_status= '2' and distcode='''||p_distcode||''';
end if;
if( role_type_code = '05' ) then
select count(*) into total_no_rtc from mybillmyright.bill_selection_details where p_status= '3' and distcode='''||p_distcode||''';
end if;

return total_no_rtc;
end;
$$;


ALTER FUNCTION mybillmyright.total_count_based_role_type_code2(role_type_code character varying, p_distcode character varying) OWNER TO postgres;

--
-- TOC entry 279 (class 1255 OID 44928)
-- Name: verifybillselection(integer, character varying, integer, integer, character varying); Type: FUNCTION; Schema: mybillmyright; Owner: postgres
--

CREATE FUNCTION mybillmyright.verifybillselection(p_bill_selection_id integer, p_process_code character varying, p_forwarded_to integer, p_logged_in_userid integer, p_remarks character varying) RETURNS SETOF character varying
    LANGUAGE plpgsql COST 10
    AS $$
DECLARE

-- billdetailid integer;
-- userid integer;
-- configcode character varying;
-- mobilenumber character varying;
-- rowCount integer;
-- rec record;
-- rec1 record;
logged_in_user_role_action_code character varying;
v_forwardedto_role_action_code character varying;
v_bill_user_id integer;
count1 integer;
count2 integer;

--select * from billdetail

BEGIN

--SET SEED TO seedValue;
SELECT roletypecode INTO logged_in_user_role_action_code FROM mybillmyright.mst_dept_user WHERE userid=p_logged_in_userid ;
SELECT roletypecode  INTO v_forwardedto_role_action_code FROM mybillmyright.mst_dept_user WHERE userid=p_forwarded_to;
SELECT userid INTO v_bill_user_id FROM mybillmyright.bill_selection_details 
        WHERE bill_selection_id = p_bill_selection_id;

-- start tracking in transaction history table 
INSERT INTO mybillmyright.history_transactions(
    transno, bill_user_id, forwarded_by, forwarded_to, forwarded_on, process_code, forwardedby_role_action_code, forwardedto_role_action_code,remarks,bill_selection_id)
    VALUES ('RANDOMID', v_bill_user_id, p_logged_in_userid, p_forwarded_to, NOW(), p_process_code, logged_in_user_role_action_code, v_forwardedto_role_action_code,p_remarks,p_bill_selection_id);
-- ADC 
if( logged_in_user_role_action_code = '02') then
    SELECT COUNT(*) INTO count1 FROM mybillmyright.transaction_detail WHERE 
    bill_selection_id=p_bill_selection_id;
    SELECT COUNT(*) INTO count2 FROM mybillmyright.transaction_detail WHERE process_code = 'R' 
    AND forwarded_to = p_logged_in_userid;
    if( count1 = 0) then
        -- start inserting records
        INSERT INTO mybillmyright.transaction_detail(bill_user_id, transno, process_code, alloted_on, forwarded_to,  
        updated_by, updated_on, forwardedto_role_action_code, updatedby_role_action_code, bill_selection_id,remarks) 
        SELECT v_bill_user_id, 'randomid', 'V', NOW(),p_forwarded_to, p_logged_in_userid, NOW(), v_forwardedto_role_action_code, 
        logged_in_user_role_action_code, p_bill_selection_id, p_remarks FROM mybillmyright.bill_selection_details 
        WHERE bill_selection_id = p_bill_selection_id;
    end if;
    if( count1 > 0 AND count2 > 0) then
        UPDATE mybillmyright.transaction_detail SET process_code='F', forwarded_to = p_forwarded_to, updated_by = p_logged_in_userid, 
        updated_on = NOW(), forwardedto_role_action_code = v_forwardedto_role_action_code, 
        updatedby_role_action_code = logged_in_user_role_action_code WHERE bill_selection_id = p_bill_selection_id AND process_code <> 'V';
    end if;
end if;
if( logged_in_user_role_action_code <> '02') then
    UPDATE mybillmyright.transaction_detail SET process_code=p_process_code, forwarded_to = p_forwarded_to, updated_by = p_logged_in_userid, 
        updated_on = NOW(), forwardedto_role_action_code = v_forwardedto_role_action_code, remarks = p_remarks ,
        updatedby_role_action_code = logged_in_user_role_action_code WHERE bill_selection_id = p_bill_selection_id ;

end if;

    return next 'success';
END

/*    
select mybillmyright.verifybillselection(58,'F',4,3)
*/
$$;


ALTER FUNCTION mybillmyright.verifybillselection(p_bill_selection_id integer, p_process_code character varying, p_forwarded_to integer, p_logged_in_userid integer, p_remarks character varying) OWNER TO postgres;

--
-- TOC entry 290 (class 1255 OID 45327)
-- Name: total_count_based_role_type_code(character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.total_count_based_role_type_code(role_type_code character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$
declare 
total_no_rtc integer;
begin
if( role_type_code = '02' ) then
select count(*) into total_no_rtc from mybillmyright.bill_selection_details where p_status= '0';
end if;
if( role_type_code = '03' ) then
select count(*) into total_no_rtc from mybillmyright.bill_selection_details where p_status= '1';
end if;
if( role_type_code = '04' ) then
select count(*) into total_no_rtc from mybillmyright.bill_selection_details where p_status= '2';
end if;
if( role_type_code = '05' ) then
select count(*) into total_no_rtc from mybillmyright.bill_selection_details where p_status= '3';
end if;




return total_no_rtc;
end;
$$;


ALTER FUNCTION public.total_count_based_role_type_code(role_type_code character varying) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 210 (class 1259 OID 44929)
-- Name: bill_selection_details; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.bill_selection_details (
    bill_selection_id integer NOT NULL,
    billdetailid integer NOT NULL,
    userid integer NOT NULL,
    configcode character varying(2) NOT NULL,
    mobilenumber character varying(10) NOT NULL,
    distcode character varying(3) NOT NULL,
    date_archived date,
    p_status character varying DEFAULT '0'::character varying,
    year_month character varying(6),
    seed_value character varying(4) NOT NULL,
    selection_value character varying(1),
    order_by_column integer
);


ALTER TABLE mybillmyright.bill_selection_details OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 44935)
-- Name: bill_selection_details_bill_selection_id_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.bill_selection_details_bill_selection_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.bill_selection_details_bill_selection_id_seq OWNER TO postgres;

--
-- TOC entry 3608 (class 0 OID 0)
-- Dependencies: 211
-- Name: bill_selection_details_bill_selection_id_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.bill_selection_details_bill_selection_id_seq OWNED BY mybillmyright.bill_selection_details.bill_selection_id;


--
-- TOC entry 212 (class 1259 OID 44936)
-- Name: bill_selection_history; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.bill_selection_history (
    bill_selection_history_id integer NOT NULL,
    bill_selection_id integer NOT NULL,
    billdetailid integer NOT NULL,
    userid integer NOT NULL,
    configcode character varying(2) NOT NULL,
    mobilenumber character varying(10) NOT NULL,
    distcode character varying(3) NOT NULL,
    date_archived date,
    p_status character varying DEFAULT '0'::character varying,
    year_month character varying(6),
    seed_value character varying(4) NOT NULL,
    selection_value character varying(1)
);


ALTER TABLE mybillmyright.bill_selection_history OWNER TO postgres;

--
-- TOC entry 213 (class 1259 OID 44942)
-- Name: bill_selection_history_bill_selection_history_id_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.bill_selection_history_bill_selection_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.bill_selection_history_bill_selection_history_id_seq OWNER TO postgres;

--
-- TOC entry 3609 (class 0 OID 0)
-- Dependencies: 213
-- Name: bill_selection_history_bill_selection_history_id_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.bill_selection_history_bill_selection_history_id_seq OWNED BY mybillmyright.bill_selection_history.bill_selection_history_id;


--
-- TOC entry 214 (class 1259 OID 44943)
-- Name: billdetail; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.billdetail (
    billdetailid integer NOT NULL,
    userid integer NOT NULL,
    configcode character varying(2) NOT NULL,
    mobilenumber character varying(10) NOT NULL,
    billnumber character varying(10) NOT NULL,
    billdate date NOT NULL,
    shopname character varying(100) NOT NULL,
    billamount numeric NOT NULL,
    statecode character varying(2) NOT NULL,
    distcode character varying(3) NOT NULL,
    filename character varying(200),
    fileextension character varying(20),
    filesize character varying(10),
    mimetype character varying(50),
    filepath character varying(200),
    acknumber character varying(25) NOT NULL,
    uploadedby integer DEFAULT 1,
    uploadedon timestamp without time zone,
    statusflag character(1)
);


ALTER TABLE mybillmyright.billdetail OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 44949)
-- Name: billdetail_billdetailid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.billdetail_billdetailid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.billdetail_billdetailid_seq OWNER TO postgres;

--
-- TOC entry 3610 (class 0 OID 0)
-- Dependencies: 215
-- Name: billdetail_billdetailid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.billdetail_billdetailid_seq OWNED BY mybillmyright.billdetail.billdetailid;


--
-- TOC entry 259 (class 1259 OID 45474)
-- Name: history_transactions; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.history_transactions (
    transhistory_id integer NOT NULL,
    transno character varying(20) NOT NULL,
    bill_user_id integer,
    forwarded_by integer NOT NULL,
    forwarded_to integer NOT NULL,
    forwarded_on timestamp without time zone,
    remarks character varying(300),
    trans_status character(1),
    process_code character varying(2),
    forwardedby_role_action_code character varying(2),
    forwardedto_role_action_code character varying(2),
    bill_selection_id integer
);


ALTER TABLE mybillmyright.history_transactions OWNER TO postgres;

--
-- TOC entry 258 (class 1259 OID 45473)
-- Name: history_transactions_transhistory_id_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.history_transactions_transhistory_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.history_transactions_transhistory_id_seq OWNER TO postgres;

--
-- TOC entry 3611 (class 0 OID 0)
-- Dependencies: 258
-- Name: history_transactions_transhistory_id_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.history_transactions_transhistory_id_seq OWNED BY mybillmyright.history_transactions.transhistory_id;


--
-- TOC entry 216 (class 1259 OID 44954)
-- Name: mst_charge; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_charge (
    chargeid integer NOT NULL,
    chargecode character varying(20),
    chargedescription character varying(100),
    divisioncode character varying(3),
    zonecode character varying(3),
    configcode character varying(2),
    statusflag character varying(1),
    createdby integer,
    updatedby integer,
    createdon timestamp without time zone,
    updatedon timestamp without time zone,
    roleid integer,
    distcode character varying(3),
    circleid integer,
    roletypecode character varying(2),
    roleactioncode character varying(2)
);


ALTER TABLE mybillmyright.mst_charge OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 44957)
-- Name: mst_charge_chargeid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_charge_chargeid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_charge_chargeid_seq OWNER TO postgres;

--
-- TOC entry 3612 (class 0 OID 0)
-- Dependencies: 217
-- Name: mst_charge_chargeid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_charge_chargeid_seq OWNED BY mybillmyright.mst_charge.chargeid;


--
-- TOC entry 218 (class 1259 OID 44958)
-- Name: mst_circle; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_circle (
    circlecode character varying(4) NOT NULL,
    circlename character varying(100),
    divisioncode character varying(4) NOT NULL,
    zonecode character varying(4) NOT NULL,
    distcode character varying(4) NOT NULL,
    state_code character varying,
    status_flag character(1),
    createdby integer,
    createdon timestamp without time zone,
    updatedby integer,
    updatedon timestamp without time zone,
    circleid integer NOT NULL,
    roletypecode character varying(2)
);


ALTER TABLE mybillmyright.mst_circle OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 44963)
-- Name: mst_circle_circleid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_circle_circleid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_circle_circleid_seq OWNER TO postgres;

--
-- TOC entry 3613 (class 0 OID 0)
-- Dependencies: 219
-- Name: mst_circle_circleid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_circle_circleid_seq OWNED BY mybillmyright.mst_circle.circleid;


--
-- TOC entry 220 (class 1259 OID 44964)
-- Name: mst_config_configid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_config_configid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_config_configid_seq OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 44965)
-- Name: mst_config; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_config (
    schemecode character varying(2) NOT NULL,
    configcode character varying(2) NOT NULL,
    statecode character varying(2) NOT NULL,
    distcode character varying(3) NOT NULL,
    minimumbillamt integer,
    prizeamount bigint,
    billentrystartdate timestamp without time zone,
    billentryenddate timestamp without time zone,
    billpurchasestartdate timestamp without time zone,
    billpurchaseenddate timestamp without time zone,
    billdrawdate timestamp without time zone,
    yymm character varying(6),
    statusflag character(1),
    createdby integer,
    createdon timestamp without time zone,
    updatedby integer,
    updatedon timestamp without time zone,
    allotment_status character(1) DEFAULT 'N'::bpchar,
    finyear integer,
    finmonth character varying,
    configid integer DEFAULT nextval('mybillmyright.mst_config_configid_seq'::regclass) NOT NULL,
    allotmentby character(1),
    allotmentdoneby integer,
    bill_selection_count integer
);


ALTER TABLE mybillmyright.mst_config OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 44972)
-- Name: mst_configlog; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_configlog (
    configlogid integer NOT NULL,
    configid integer NOT NULL,
    schemecode character varying(2) NOT NULL,
    configcode character varying(2) NOT NULL,
    statecode character varying(2) NOT NULL,
    distcode character varying(3) NOT NULL,
    minimumbillamt integer,
    prizeamount bigint,
    billentrystartdate timestamp without time zone,
    billentryenddate timestamp without time zone,
    billpurchasestartdate timestamp without time zone,
    billpurchaseenddate timestamp without time zone,
    billdrawdate timestamp without time zone,
    yymm character varying(6) NOT NULL,
    statusflag character(1),
    createdby integer,
    createdon timestamp without time zone,
    updatedby integer,
    updatedon timestamp without time zone
);


ALTER TABLE mybillmyright.mst_configlog OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 44975)
-- Name: mst_dept_user; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_dept_user (
    userid integer NOT NULL,
    email character varying(50) NOT NULL,
    pwd character varying(200),
    name character varying(50) NOT NULL,
    mobilenumber character varying(10) NOT NULL,
    statecode character varying(2) DEFAULT 'TN'::character varying NOT NULL,
    distcode character varying(3),
    createdby integer DEFAULT 1 NOT NULL,
    createdon timestamp without time zone,
    updatedby integer DEFAULT 1,
    updatedon timestamp without time zone,
    statusflag boolean DEFAULT true,
    profile_update character(1),
    divisioncode character varying(4),
    zonecode character varying(4),
    circleid integer,
    dateofbirth date,
    nodal character(1),
    lott_executor character(1),
    empid character varying(10),
    roletypecode character varying(2)
);


ALTER TABLE mybillmyright.mst_dept_user OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 44982)
-- Name: mst_dept_user_userid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_dept_user_userid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_dept_user_userid_seq OWNER TO postgres;

--
-- TOC entry 3615 (class 0 OID 0)
-- Dependencies: 224
-- Name: mst_dept_user_userid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_dept_user_userid_seq OWNED BY mybillmyright.mst_dept_user.userid;


--
-- TOC entry 225 (class 1259 OID 44983)
-- Name: mst_district; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_district (
    distid integer NOT NULL,
    distcode character varying(3) NOT NULL,
    statecode character varying(2),
    distename character varying(50),
    flag character(1),
    createdon timestamp without time zone,
    createdby integer,
    updatedby integer,
    updatedon timestamp without time zone
);


ALTER TABLE mybillmyright.mst_district OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 44986)
-- Name: mst_division; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_division (
    divisionid integer NOT NULL,
    divisioncode character varying(2) NOT NULL,
    divisionsname character varying(10),
    divisionlname character varying(100),
    statecode character varying,
    statusflag character(1),
    createdby integer,
    createdon timestamp without time zone,
    updatedby integer,
    updatedon timestamp without time zone
);


ALTER TABLE mybillmyright.mst_division OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 44991)
-- Name: mst_division_divisionid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_division_divisionid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_division_divisionid_seq OWNER TO postgres;

--
-- TOC entry 3616 (class 0 OID 0)
-- Dependencies: 227
-- Name: mst_division_divisionid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_division_divisionid_seq OWNED BY mybillmyright.mst_division.divisionid;


--
-- TOC entry 228 (class 1259 OID 44992)
-- Name: mst_menu_menuid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_menu_menuid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_menu_menuid_seq OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 44993)
-- Name: mst_menu; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_menu (
    statecode character varying(3),
    menuname character varying(50),
    levelid integer,
    parentid integer,
    menuurl character varying(200),
    status character varying(1),
    createdby integer,
    createdon timestamp without time zone,
    updatedby integer,
    updatedon timestamp without time zone,
    key character varying(30),
    order_id integer,
    menuid integer DEFAULT nextval('mybillmyright.mst_menu_menuid_seq'::regclass) NOT NULL
);


ALTER TABLE mybillmyright.mst_menu OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 44997)
-- Name: mst_menu_mapping; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_menu_mapping (
    menuid integer NOT NULL,
    roleid integer NOT NULL,
    control_json jsonb
);


ALTER TABLE mybillmyright.mst_menu_mapping OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 45002)
-- Name: mst_menu_mapping_menuid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_menu_mapping_menuid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_menu_mapping_menuid_seq OWNER TO postgres;

--
-- TOC entry 3618 (class 0 OID 0)
-- Dependencies: 231
-- Name: mst_menu_mapping_menuid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_menu_mapping_menuid_seq OWNED BY mybillmyright.mst_menu_mapping.menuid;


--
-- TOC entry 232 (class 1259 OID 45003)
-- Name: mst_role; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_role (
    roleid integer NOT NULL,
    statecode character varying(3),
    rolesname character varying(50),
    rolelname character varying(100),
    status character(1),
    createdby integer,
    createdon timestamp without time zone,
    updatedby integer,
    updatedon timestamp without time zone,
    usertypecode character varying(2),
    roletypecode character varying(2),
    roleactioncode character varying(2)
);


ALTER TABLE mybillmyright.mst_role OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 45006)
-- Name: mst_role_roleid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_role_roleid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_role_roleid_seq OWNER TO postgres;

--
-- TOC entry 3619 (class 0 OID 0)
-- Dependencies: 233
-- Name: mst_role_roleid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_role_roleid_seq OWNED BY mybillmyright.mst_role.roleid;


--
-- TOC entry 234 (class 1259 OID 45007)
-- Name: mst_roleaction; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_roleaction (
    roleactioncode character varying(2) NOT NULL,
    roleactionsname character varying(3),
    roleactionlname character varying(50),
    statusflag character(1),
    createdby integer,
    createdon time without time zone,
    updatedby integer,
    updatedon time without time zone,
    roletypecode character varying(2),
    roleactionid integer NOT NULL
);


ALTER TABLE mybillmyright.mst_roleaction OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 45010)
-- Name: mst_roleaction_roleactionid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_roleaction_roleactionid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_roleaction_roleactionid_seq OWNER TO postgres;

--
-- TOC entry 3620 (class 0 OID 0)
-- Dependencies: 235
-- Name: mst_roleaction_roleactionid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_roleaction_roleactionid_seq OWNED BY mybillmyright.mst_roleaction.roleactionid;


--
-- TOC entry 236 (class 1259 OID 45011)
-- Name: mst_roletype; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_roletype (
    roletypecode character varying(2) NOT NULL,
    roletypelname character varying(50),
    statusflag character(1),
    createdby integer,
    createdon timestamp without time zone,
    updatedby integer,
    updatedon timestamp without time zone,
    usertypecode character varying(2),
    roletypeid integer NOT NULL
);


ALTER TABLE mybillmyright.mst_roletype OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 45014)
-- Name: mst_roletype_roletypeid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_roletype_roletypeid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_roletype_roletypeid_seq OWNER TO postgres;

--
-- TOC entry 3621 (class 0 OID 0)
-- Dependencies: 237
-- Name: mst_roletype_roletypeid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_roletype_roletypeid_seq OWNED BY mybillmyright.mst_roletype.roletypeid;


--
-- TOC entry 238 (class 1259 OID 45015)
-- Name: mst_scheme; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_scheme (
    schemeid integer NOT NULL,
    schemecode character varying(2) NOT NULL,
    schemesname character varying(10),
    schemelname character varying(50),
    minimumbillamt integer,
    prizeamount bigint,
    billentrystartdate timestamp without time zone,
    billentryenddate timestamp without time zone,
    billpurchasestartdate timestamp without time zone,
    billpurchaseenddate timestamp without time zone,
    billdrawdate timestamp without time zone,
    finyear integer,
    statusflag character(1),
    yymm character varying(6) NOT NULL,
    configstate_dist character(1) NOT NULL,
    createdby integer,
    createdon timestamp without time zone,
    updatedby integer,
    updatedon timestamp without time zone,
    statecode character varying(2)
);


ALTER TABLE mybillmyright.mst_scheme OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 45018)
-- Name: mst_state; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_state (
    stateid integer NOT NULL,
    statecode character varying(2) NOT NULL,
    stateename character varying(50),
    statetname character varying(50),
    stateut character varying(1),
    flag character varying(1),
    createdon timestamp without time zone,
    createdby integer,
    updatedby integer,
    updatedon timestamp without time zone
);


ALTER TABLE mybillmyright.mst_state OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 45021)
-- Name: mst_user; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_user (
    userid integer NOT NULL,
    schemecode character varying(2) DEFAULT '01'::character varying NOT NULL,
    email character varying(50) NOT NULL,
    pwd character varying(200),
    name character varying(50) NOT NULL,
    mobilenumber character varying(10) NOT NULL,
    statecode character varying(2) DEFAULT 'TN'::character varying NOT NULL,
    distcode character varying(3),
    ipaddress character varying(20),
    deviceid character varying(1),
    addr1 character varying(100) DEFAULT 'Address 1'::character varying NOT NULL,
    addr2 character varying(100) DEFAULT 'Address 2'::character varying NOT NULL,
    pincode character varying(6) DEFAULT '600000'::character varying NOT NULL,
    createdby integer DEFAULT 1 NOT NULL,
    createdon timestamp without time zone,
    updatedby integer DEFAULT 1,
    updatedon timestamp without time zone,
    statusflag boolean DEFAULT true,
    profile_update character(1),
    chargeid integer,
    roleid integer,
    roletypecode character varying(2)
);


ALTER TABLE mybillmyright.mst_user OWNER TO postgres;

--
-- TOC entry 241 (class 1259 OID 45034)
-- Name: mst_user_charge; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_user_charge (
    userchargeid integer NOT NULL,
    statecode character varying(3),
    userid integer,
    divisioncode character varying(3),
    zonecode character varying(3),
    configcode character varying(2),
    charge_from date,
    statusflag character varying(1),
    createdby integer,
    createdon timestamp without time zone,
    updatedby integer,
    updatedon timestamp without time zone,
    chargeid integer,
    roleid integer,
    circleid integer,
    distcode character varying(3),
    roletypecode character varying(2)
);


ALTER TABLE mybillmyright.mst_user_charge OWNER TO postgres;

--
-- TOC entry 242 (class 1259 OID 45037)
-- Name: mst_user_charge_userchargeid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_user_charge_userchargeid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_user_charge_userchargeid_seq OWNER TO postgres;

--
-- TOC entry 3622 (class 0 OID 0)
-- Dependencies: 242
-- Name: mst_user_charge_userchargeid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_user_charge_userchargeid_seq OWNED BY mybillmyright.mst_user_charge.userchargeid;


--
-- TOC entry 243 (class 1259 OID 45038)
-- Name: mst_user_userid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_user_userid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_user_userid_seq OWNER TO postgres;

--
-- TOC entry 3623 (class 0 OID 0)
-- Dependencies: 243
-- Name: mst_user_userid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_user_userid_seq OWNED BY mybillmyright.mst_user.userid;


--
-- TOC entry 244 (class 1259 OID 45039)
-- Name: mst_userlog; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_userlog (
    userlogid integer NOT NULL,
    userid integer NOT NULL,
    schemecode character varying(2) NOT NULL,
    email character varying(50) NOT NULL,
    pwd character varying(300),
    name character varying(50) NOT NULL,
    mobilenumber character varying(10) NOT NULL,
    statusflag character(1) DEFAULT true NOT NULL,
    statecode character varying(2),
    distcode character varying(3),
    ipaddress character varying(20),
    deviceid character varying(1),
    addr1 character varying(100),
    adr2 character varying(100),
    pincode integer,
    createdby integer DEFAULT 1 NOT NULL,
    createdon timestamp without time zone,
    updatedby integer DEFAULT 1,
    updatedon timestamp without time zone
);


ALTER TABLE mybillmyright.mst_userlog OWNER TO postgres;

--
-- TOC entry 245 (class 1259 OID 45047)
-- Name: mst_userlog_userlogid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_userlog_userlogid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_userlog_userlogid_seq OWNER TO postgres;

--
-- TOC entry 3624 (class 0 OID 0)
-- Dependencies: 245
-- Name: mst_userlog_userlogid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_userlog_userlogid_seq OWNED BY mybillmyright.mst_userlog.userlogid;


--
-- TOC entry 246 (class 1259 OID 45048)
-- Name: mst_userlogindetail; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_userlogindetail (
    userid integer NOT NULL,
    mobilenumber character varying(10) NOT NULL,
    ipaddress character varying(20),
    deviceid character varying(1),
    logintime timestamp without time zone,
    logouttime timestamp without time zone,
    logoutstatus integer NOT NULL,
    userloginid integer NOT NULL
);


ALTER TABLE mybillmyright.mst_userlogindetail OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 45051)
-- Name: mst_userlogindetail_userloginid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_userlogindetail_userloginid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_userlogindetail_userloginid_seq OWNER TO postgres;

--
-- TOC entry 3625 (class 0 OID 0)
-- Dependencies: 247
-- Name: mst_userlogindetail_userloginid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_userlogindetail_userloginid_seq OWNED BY mybillmyright.mst_userlogindetail.userloginid;


--
-- TOC entry 248 (class 1259 OID 45052)
-- Name: mst_usertype; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_usertype (
    usertypeid integer NOT NULL,
    usertypesname character varying(50),
    usertypelname character varying(100),
    status character(1),
    createdby integer,
    createdon timestamp without time zone,
    updatedby integer,
    updatedon timestamp without time zone,
    usertypecode character varying(2) NOT NULL
);


ALTER TABLE mybillmyright.mst_usertype OWNER TO postgres;

--
-- TOC entry 249 (class 1259 OID 45055)
-- Name: mst_usertype_usertypeid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_usertype_usertypeid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_usertype_usertypeid_seq OWNER TO postgres;

--
-- TOC entry 3626 (class 0 OID 0)
-- Dependencies: 249
-- Name: mst_usertype_usertypeid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_usertype_usertypeid_seq OWNED BY mybillmyright.mst_usertype.usertypeid;


--
-- TOC entry 250 (class 1259 OID 45056)
-- Name: mst_zone; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.mst_zone (
    zoneid integer NOT NULL,
    zonecode character varying(2) NOT NULL,
    zonesname character varying(10),
    zonelname character varying(100),
    statecode character varying,
    statusflag character(1),
    createdby integer,
    createdon timestamp without time zone,
    updatedby integer,
    updatedon timestamp without time zone
);


ALTER TABLE mybillmyright.mst_zone OWNER TO postgres;

--
-- TOC entry 251 (class 1259 OID 45061)
-- Name: mst_zone_zoneid_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.mst_zone_zoneid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.mst_zone_zoneid_seq OWNER TO postgres;

--
-- TOC entry 3627 (class 0 OID 0)
-- Dependencies: 251
-- Name: mst_zone_zoneid_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.mst_zone_zoneid_seq OWNED BY mybillmyright.mst_zone.zoneid;


--
-- TOC entry 252 (class 1259 OID 45062)
-- Name: test; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.test (
    id integer NOT NULL,
    fname character varying NOT NULL
);


ALTER TABLE mybillmyright.test OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 45067)
-- Name: test_id_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.test_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.test_id_seq OWNER TO postgres;

--
-- TOC entry 3628 (class 0 OID 0)
-- Dependencies: 253
-- Name: test_id_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.test_id_seq OWNED BY mybillmyright.test.id;


--
-- TOC entry 254 (class 1259 OID 45068)
-- Name: transaction_detail; Type: TABLE; Schema: mybillmyright; Owner: postgres
--

CREATE TABLE mybillmyright.transaction_detail (
    trans_id integer NOT NULL,
    transno character varying(20) NOT NULL,
    bill_user_id integer,
    process_code character varying(2),
    alloted_by integer,
    alloted_on timestamp without time zone,
    forwarded_to integer,
    remarks character varying(250),
    updated_by integer,
    updated_on timestamp without time zone,
    forwardedto_role_action_code character varying,
    updatedby_role_action_code character varying,
    bill_selection_id integer
);


ALTER TABLE mybillmyright.transaction_detail OWNER TO postgres;

--
-- TOC entry 255 (class 1259 OID 45073)
-- Name: transaction_detail_trans_id_seq; Type: SEQUENCE; Schema: mybillmyright; Owner: postgres
--

CREATE SEQUENCE mybillmyright.transaction_detail_trans_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE mybillmyright.transaction_detail_trans_id_seq OWNER TO postgres;

--
-- TOC entry 3629 (class 0 OID 0)
-- Dependencies: 255
-- Name: transaction_detail_trans_id_seq; Type: SEQUENCE OWNED BY; Schema: mybillmyright; Owner: postgres
--

ALTER SEQUENCE mybillmyright.transaction_detail_trans_id_seq OWNED BY mybillmyright.transaction_detail.trans_id;


--
-- TOC entry 256 (class 1259 OID 45074)
-- Name: test; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.test (
    id integer NOT NULL,
    name character varying(20)
);


ALTER TABLE public.test OWNER TO postgres;

--
-- TOC entry 257 (class 1259 OID 45077)
-- Name: test_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.test_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.test_id_seq OWNER TO postgres;

--
-- TOC entry 3630 (class 0 OID 0)
-- Dependencies: 257
-- Name: test_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.test_id_seq OWNED BY public.test.id;


--
-- TOC entry 3313 (class 2604 OID 45078)
-- Name: bill_selection_details bill_selection_id; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.bill_selection_details ALTER COLUMN bill_selection_id SET DEFAULT nextval('mybillmyright.bill_selection_details_bill_selection_id_seq'::regclass);


--
-- TOC entry 3315 (class 2604 OID 45079)
-- Name: bill_selection_history bill_selection_history_id; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.bill_selection_history ALTER COLUMN bill_selection_history_id SET DEFAULT nextval('mybillmyright.bill_selection_history_bill_selection_history_id_seq'::regclass);


--
-- TOC entry 3317 (class 2604 OID 45080)
-- Name: billdetail billdetailid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.billdetail ALTER COLUMN billdetailid SET DEFAULT nextval('mybillmyright.billdetail_billdetailid_seq'::regclass);


--
-- TOC entry 3353 (class 2604 OID 45477)
-- Name: history_transactions transhistory_id; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.history_transactions ALTER COLUMN transhistory_id SET DEFAULT nextval('mybillmyright.history_transactions_transhistory_id_seq'::regclass);


--
-- TOC entry 3318 (class 2604 OID 45082)
-- Name: mst_charge chargeid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_charge ALTER COLUMN chargeid SET DEFAULT nextval('mybillmyright.mst_charge_chargeid_seq'::regclass);


--
-- TOC entry 3319 (class 2604 OID 45083)
-- Name: mst_circle circleid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_circle ALTER COLUMN circleid SET DEFAULT nextval('mybillmyright.mst_circle_circleid_seq'::regclass);


--
-- TOC entry 3326 (class 2604 OID 45084)
-- Name: mst_dept_user userid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_dept_user ALTER COLUMN userid SET DEFAULT nextval('mybillmyright.mst_dept_user_userid_seq'::regclass);


--
-- TOC entry 3327 (class 2604 OID 45085)
-- Name: mst_division divisionid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_division ALTER COLUMN divisionid SET DEFAULT nextval('mybillmyright.mst_division_divisionid_seq'::regclass);


--
-- TOC entry 3329 (class 2604 OID 45086)
-- Name: mst_menu_mapping menuid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_menu_mapping ALTER COLUMN menuid SET DEFAULT nextval('mybillmyright.mst_menu_mapping_menuid_seq'::regclass);


--
-- TOC entry 3330 (class 2604 OID 45087)
-- Name: mst_role roleid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_role ALTER COLUMN roleid SET DEFAULT nextval('mybillmyright.mst_role_roleid_seq'::regclass);


--
-- TOC entry 3331 (class 2604 OID 45088)
-- Name: mst_roleaction roleactionid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_roleaction ALTER COLUMN roleactionid SET DEFAULT nextval('mybillmyright.mst_roleaction_roleactionid_seq'::regclass);


--
-- TOC entry 3332 (class 2604 OID 45089)
-- Name: mst_roletype roletypeid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_roletype ALTER COLUMN roletypeid SET DEFAULT nextval('mybillmyright.mst_roletype_roletypeid_seq'::regclass);


--
-- TOC entry 3341 (class 2604 OID 45090)
-- Name: mst_user userid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_user ALTER COLUMN userid SET DEFAULT nextval('mybillmyright.mst_user_userid_seq'::regclass);


--
-- TOC entry 3342 (class 2604 OID 45091)
-- Name: mst_user_charge userchargeid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_user_charge ALTER COLUMN userchargeid SET DEFAULT nextval('mybillmyright.mst_user_charge_userchargeid_seq'::regclass);


--
-- TOC entry 3346 (class 2604 OID 45092)
-- Name: mst_userlog userlogid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_userlog ALTER COLUMN userlogid SET DEFAULT nextval('mybillmyright.mst_userlog_userlogid_seq'::regclass);


--
-- TOC entry 3347 (class 2604 OID 45093)
-- Name: mst_userlogindetail userloginid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_userlogindetail ALTER COLUMN userloginid SET DEFAULT nextval('mybillmyright.mst_userlogindetail_userloginid_seq'::regclass);


--
-- TOC entry 3348 (class 2604 OID 45094)
-- Name: mst_usertype usertypeid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_usertype ALTER COLUMN usertypeid SET DEFAULT nextval('mybillmyright.mst_usertype_usertypeid_seq'::regclass);


--
-- TOC entry 3349 (class 2604 OID 45095)
-- Name: mst_zone zoneid; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_zone ALTER COLUMN zoneid SET DEFAULT nextval('mybillmyright.mst_zone_zoneid_seq'::regclass);


--
-- TOC entry 3350 (class 2604 OID 45096)
-- Name: test id; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.test ALTER COLUMN id SET DEFAULT nextval('mybillmyright.test_id_seq'::regclass);


--
-- TOC entry 3351 (class 2604 OID 45097)
-- Name: transaction_detail trans_id; Type: DEFAULT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.transaction_detail ALTER COLUMN trans_id SET DEFAULT nextval('mybillmyright.transaction_detail_trans_id_seq'::regclass);


--
-- TOC entry 3352 (class 2604 OID 45098)
-- Name: test id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.test ALTER COLUMN id SET DEFAULT nextval('public.test_id_seq'::regclass);


--
-- TOC entry 3553 (class 0 OID 44929)
-- Dependencies: 210
-- Data for Name: bill_selection_details; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.bill_selection_details (bill_selection_id, billdetailid, userid, configcode, mobilenumber, distcode, date_archived, p_status, year_month, seed_value, selection_value, order_by_column) FROM stdin;
\.


--
-- TOC entry 3555 (class 0 OID 44936)
-- Dependencies: 212
-- Data for Name: bill_selection_history; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.bill_selection_history (bill_selection_history_id, bill_selection_id, billdetailid, userid, configcode, mobilenumber, distcode, date_archived, p_status, year_month, seed_value, selection_value) FROM stdin;
\.


--
-- TOC entry 3557 (class 0 OID 44943)
-- Dependencies: 214
-- Data for Name: billdetail; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.billdetail (billdetailid, userid, configcode, mobilenumber, billnumber, billdate, shopname, billamount, statecode, distcode, filename, fileextension, filesize, mimetype, filepath, acknumber, uploadedby, uploadedon, statusflag) FROM stdin;
185	85	03	9487687827	0000007877	2023-02-14	Sarava Store	78776787	TN	610	1dc5c65432e651b4e58be36ab2605def_screencapture-10-163-19-176-postgresounsil-updating-Etransfer-approved-details-2023-02-16-10_51_31.pdf	\N	322.80 KB	application/pdf	2023/610/02/1dc5c65432e651b4e58be36ab2605def_screencapture-10-163-19-176-postgresounsil-updating-Etransfer-approved-details-2023-02-16-10_51_31.pdf	5978272023021487778776787	85	2023-03-27 15:46:10	N
235	91	03	9876543222	0000434324	2023-03-21	rwerewrew	3432	TN	578	0b39382ad818183fc5b1e9e643c6f718	\N	270.51 KB	image/png	2023/578/03/0b39382ad818183fc5b1e9e643c6f718	202304/578/222/324/908102	91	2023-04-19 22:45:24	N
184	85	03	9487687827	0000000200	2023-02-09	saravana	20000	TN	610	a67690e74bf36fefc8b8bd0e627cba80_form11.pdf		472.77 KB	application/pdf	2023/610/02/a67690e74bf36fefc8b8bd0e627cba80_form11.pdf	5978272023020920000020000	85	2023-03-27 15:46:54	Y
188	83	02	9159698082	0000056985	2023-02-17	pothys	3880	TN	610	aa0138f977a2d29a72a6fafe983a9a49_		163.61 KB	image/jpeg	2023/610/02/aa0138f977a2d29a72a6fafe983a9a49_	202210/610/378/985/000001	83	2023-03-27 15:50:17	N
199	85	03	9487687827	0000000434	2023-02-15	test	45	TN	610	dcf8e081b6a72ba95b5f5b6c415f99d2_screencapture-10-163-19-176-postgresounsil-updating-Etransfer-approved-details-2023-02-16-10_51_31.pdf	\N	322.80 KB	application/pdf	2023/610/02/dcf8e081b6a72ba95b5f5b6c415f99d2_screencapture-10-163-19-176-postgresounsil-updating-Etransfer-approved-details-2023-02-16-10_51_31.pdf	202303/597/827/434/543446	85	2023-03-27 18:00:33	N
187	85	03	9487687827	0000000521	2023-02-16	Pothys	56000	TN	610	240131568399f8fa26e1a10ccee606c0_sivananthan_cv.pdf	\N	136.58 KB	application/pdf	2023/610/02/240131568399f8fa26e1a10ccee606c0_sivananthan_cv.pdf	5978272023021652100056000	85	2023-03-27 15:51:29	Y
189	83	02	9159698082	0000067896	2023-02-17	chennai silks	2500	TN	610	3715662b7781a11426f852da2a43c70d_		75.16 KB	image/jpeg	2023/610/02/3715662b7781a11426f852da2a43c70d_	202210/610/378/896/000001	83	2023-03-27 16:03:50	N
236	91	03	9876543222	0000000464	2023-03-22	test shop	5456	TN	578	462e28aace51abe7b13aaf4dcdc8a3fd		75.93 KB	image/png	2023/578/03/462e28aace51abe7b13aaf4dcdc8a3fd	202304/578/222/464/248481	91	2023-04-20 10:54:03	N
237	91	03	9876543222	0000005757	2023-03-31	testtet	345	TN	578	32fa02589ab55d3cd3c738afd7556763	\N	14.77 KB	image/jpeg	2023/578/03/32fa02589ab55d3cd3c738afd7556763	202304/578/222/757/677394	91	2023-04-20 10:56:16	N
193	83	03	9159698082	0000845745	2023-02-16	GH2	2582	TN	586	eb5511713aa381d9e29fcd0f32ea6892_		112.60 KB	image/jpeg	2023/586/02/eb5511713aa381d9e29fcd0f32ea6892_	202211/586/082/745/000001	83	2023-03-27 17:04:52	N
194	83	03	9159698082	0000000045	2023-02-09	poi	5000	TN	586	b4c930beff3b43467ce743a835553db1_		112.60 KB	image/jpeg	2023/586/02/b4c930beff3b43467ce743a835553db1_	202211/586/082/045/000001	83	2023-03-27 17:15:05	N
195	83	03	9159698082	0000000158	2023-02-01	kill	1400	TN	586	c57180dafe72690d8c6b4e3ce1c2a486_		97.13 KB	image/jpeg	2023/586/02/c57180dafe72690d8c6b4e3ce1c2a486_	202211/586/082/158/000001	83	2023-03-27 17:17:30	N
196	83	03	9159698082	0845878554	2023-02-17	Asika Jewellery	2500	TN	586	27f1e60a78958ae5db1d03b87966c3a8_		112.60 KB	image/jpeg	2023/586/02/27f1e60a78958ae5db1d03b87966c3a8_	202211/586/082/554/000001	83	2023-03-27 17:20:32	N
197	83	03	9159698082	0000789455	2023-02-18	SIva Infotech	2500	TN	586	df3145e34fcaa169033d41f224cd07f5_		112.60 KB	image/jpeg	2023/586/02/df3145e34fcaa169033d41f224cd07f5_	202211/586/082/455/000001	83	2023-03-27 17:22:19	N
200	85	03	9487687827	0000000433	2023-02-15	test	45	TN	610	6333bb3a9cd3e8c029128c4744b51386_screencapture-10-163-19-176-postgresounsil-updating-Etransfer-approved-details-2023-02-16-10_51_31.pdf	\N	322.80 KB	application/pdf	2023/610/02/6333bb3a9cd3e8c029128c4744b51386_screencapture-10-163-19-176-postgresounsil-updating-Etransfer-approved-details-2023-02-16-10_51_31.pdf	202303/597/827/433/851858	85	2023-03-27 18:01:17	N
201	85	03	9487687827	0000003424	2023-02-09	test	45	TN	610	5d0c3010cc844b667b8a720c2bc69e11_TNeGA - Directorate of Medical and Rural Health Services V1.0.pdf	\N	2.87 MB	application/pdf	2023/610/02/5d0c3010cc844b667b8a720c2bc69e11_TNeGA - Directorate of Medical and Rural Health Services V1.0.pdf	202303/597/827/424/694731	85	2023-03-27 18:01:37	N
206	83	03	9159698082	0000006616	2023-02-17	Raman and Raman	12000	TN	586	d3a586200d8e557a34def4ff1da27ad8_		399.94 KB	image/jpeg	2023/586/02/d3a586200d8e557a34def4ff1da27ad8_	202211/586/082/616/000001	83	2023-03-27 19:12:48	N
203	83	03	9159698082	0000005689	2023-02-14	Jos Alukas	5000	TN	586	22f6915c027b71c2d9ae3825765194ca_		112.60 KB	image/jpeg	2023/586/02/22f6915c027b71c2d9ae3825765194ca_	202211/586/082/689/000001	83	2023-03-27 18:17:27	N
207	86	03	6383839415	0000002200	2023-02-13	Pratap pawn broker tvm	15310	TN	586	8f671dbd7e893ea0fd472dfba6ff28ee_		520.40 KB	image/jpeg	2023/586/02/8f671dbd7e893ea0fd472dfba6ff28ee_	202211/586/082/200/000001	86	2023-03-27 21:04:23	N
205	83	03	9159698082	0005698745	2023-02-15	Nic Private Ltd	5000	TN	586	aa470685cd2fe332f7f9a554c4d7be3b_		112.60 KB	image/jpeg	2023/586/02/aa470685cd2fe332f7f9a554c4d7be3b_	202211/586/082/745/000001	83	2023-03-27 18:31:55	N
198	83	03	9159698082	0000000442	2023-02-22	Cotton house thiruvanmiyur	1837	TN	586	c38c37952f0b4bedd4315c519a8713a5_		181.82 KB	image/jpeg	2023/586/02/c38c37952f0b4bedd4315c519a8713a5_	202211/586/082/442/000001	83	2023-03-27 20:56:17	N
209	86	02	6383839415	0000000210	2023-02-09	R.Mukesh kumar	24000	TN	610	89779dd94e4ed123f4a4d63d5d9143d9_		174.02 KB	image/jpeg	2023/610/02/89779dd94e4ed123f4a4d63d5d9143d9_	202210/610/415/210/000001	86	2023-03-27 21:07:45	N
202	83	03	9159698082	0000005689	2023-02-22	Kotak Mahindra	9800	TN	586	de2fdaf236510e80b03a11a91b12584a_		149.27 KB	image/jpeg	2023/586/02/de2fdaf236510e80b03a11a91b12584a_	202211/586/082/689/000001	83	2023-03-27 18:34:37	N
186	83	03	9159698082	0000420067	2023-02-10	Saravana store	5000	TN	586	3a5712d58ad8f83c969a34f2cb5f8514_		616.67 KB	image/jpeg	2023/586/02/3a5712d58ad8f83c969a34f2cb5f8514_	202303/586/082/067/000001	83	2023-03-27 15:46:58	N
208	86	03	6383839415	0000000124	2023-02-25	Mukesh kumar	7500	TN	586	0d6bab3cf6e8361e0274dac73fdc5840_		176.70 KB	image/jpeg	2023/586/02/0d6bab3cf6e8361e0274dac73fdc5840_	202211/586/082/124/000001	86	2023-03-27 21:06:18	N
210	86	02	6383839415	0000002235	2023-02-16	Pratap pawn broker	8000	TN	610	b00209719fba54ff070eff82793865ba_		178.71 KB	image/jpeg	2023/610/02/b00209719fba54ff070eff82793865ba_	202210/610/415/235/000001	86	2023-03-27 21:09:06	N
211	85	03	9487687827	0000002803	2023-02-15	test shop	343	TN	610	635b947863b3988dcd2f390a1ff24d80_Pensioner_Portal_Help_File.pdf	\N	488.67 KB	application/pdf	2023/610/02/635b947863b3988dcd2f390a1ff24d80_Pensioner_Portal_Help_File.pdf	202303/597/827/803/160387	85	2023-03-28 10:31:45	N
204	83	03	9159698082	0000000529	2023-02-28	Cotton House	1717	TN	586	16d21fb0c04242d4e953713a5ee7418d_		178.91 KB	image/jpeg	2023/586/02/16d21fb0c04242d4e953713a5ee7418d_	202211/586/082/529/000001	83	2023-03-27 20:57:05	Y
212	85	03	9487687827	0000002843	2023-02-15	test shop	343	TN	610	88624b82db5b78f8690cac9923d91b1e_Pensioner_Portal_Help_File.pdf	\N	488.67 KB	application/pdf	2023/610/02/88624b82db5b78f8690cac9923d91b1e_Pensioner_Portal_Help_File.pdf	202303/597/827/843/869020	85	2023-03-28 10:31:58	N
213	85	03	9487687827	0000123131	2023-02-15	test shop	343	TN	610	a316dc358f0847f31cf4339d149dbebc_Pensioner_Portal_Help_File.pdf	\N	488.67 KB	application/pdf	2023/610/02/a316dc358f0847f31cf4339d149dbebc_Pensioner_Portal_Help_File.pdf	202303/597/827/131/380931	85	2023-03-28 10:57:34	N
214	85	03	9487687827	0000008988	2023-02-21	siva tex	8988	TN	610	85df851cc9d3aeebc81d6289dee0276e	\N	6.27 KB	image/jpeg	2023/610/02/85df851cc9d3aeebc81d6289dee0276e	202303/597/827/988/261706	85	2023-03-28 11:22:15	N
224	88	03	9876543217	0000346546	2023-03-30	tetqerrt	3454	TN	569	2411c54ca8a2dc7f84934a06de9e8a2b	\N	23.04 KB	application/pdf	2023/569/03/2411c54ca8a2dc7f84934a06de9e8a2b	202304/569/217/546/755137	88	2023-04-17 18:19:47	N
225	88	03	9876543217	0000043554	2023-03-31	TEST	454554	TN	569	552093eb5bea13ca42ccbf2500066898	\N	76.25 KB	application/pdf	2023/569/03/552093eb5bea13ca42ccbf2500066898	202304/569/217/554/121834	88	2023-04-17 18:20:03	N
226	88	03	9876543217	0000675675	2023-03-21	test	454	TN	569	ece2cd053c29b74cde34b6e584217775	\N	23.04 KB	application/pdf	2023/569/03/ece2cd053c29b74cde34b6e584217775	202304/569/217/675/728423	88	2023-04-17 18:20:54	N
217	87	02	9080076157	0000000773	2023-01-14	siva tex	10000	TN	610	ba930a7218b324ea74f81570f025a446_		32.86 KB	image/jpeg	2023/610/02/ba930a7218b324ea74f81570f025a446_	202210/610/157/773/000001	87	2023-03-28 14:57:22	Y
228	88	03	9876543217	0000654654	2023-03-15	tertse	545	TN	569	f55f9a08a58a4b1ea47c2031c1e3e776	\N	23.04 KB	application/pdf	2023/569/03/f55f9a08a58a4b1ea47c2031c1e3e776	202304/569/217/654/146465	88	2023-04-17 18:21:25	N
229	88	03	9876543217	0000004545	2023-03-09	tyrtert	4545	TN	569	bd349f43e7240eb65148ca5507d759e6	\N	76.25 KB	application/pdf	2023/569/03/bd349f43e7240eb65148ca5507d759e6	202304/569/217/545/787369	88	2023-04-17 18:21:40	N
230	89	03	9876543219	0000000455	2023-03-16	test shop	45532	TN	569	b0a61f9dfc19b1be3af0b3f959b0c0e6	\N	76.25 KB	application/pdf	2023/569/03/b0a61f9dfc19b1be3af0b3f959b0c0e6	202304/569/219/455/391408	89	2023-04-18 12:00:21	N
215	87	03	9080076157	0000000560	2023-02-16	Lalitha	50000	TN	610	8d1cb20bdf848510afff96b636d98ab1	\N	106.14 KB	image/jpeg	2023/610/02/8d1cb20bdf848510afff96b636d98ab1	202303/610/157/560/736450	87	2023-03-28 15:41:15	N
238	92	03	9638527419	0000007887	2023-03-08	saravana Stores	88676	TN	578	4a0de8bb2b249627eee7471ec071633c	\N	466.89 KB	image/png	2023/578/03/4a0de8bb2b249627eee7471ec071633c	202304/578/419/887/199769	92	2023-04-22 16:08:35	N
219	87	03	9080076157	0000000123	2023-02-01	guhan	500	TN	586	05acd24c395a8f665cd1af7820686c71_		45.86 KB	image/jpeg	2023/586/02/05acd24c395a8f665cd1af7820686c71_	202211/586/082/123/000001	87	2023-03-28 17:13:08	Y
218	87	03	9080076157	0000000123	2023-02-01	guhan	500	TN	586	79459c6de62a2628957bb111b9344b6f	\N	239.29 KB	application/pdf	2023/586/02/79459c6de62a2628957bb111b9344b6f	202303/610/157/123/947097	87	2023-03-28 17:16:17	Y
190	83	03	9159698082	0000001456	2023-02-15	GH	8000	TN	586	201cfb15ad4ba78e696f98f083ed31b6_		112.60 KB	image/jpeg	2023/586/02/201cfb15ad4ba78e696f98f083ed31b6_	202303/586//456/000001	83	2023-03-27 16:46:13	N
191	83	03	9159698082	0000000789	2023-02-15	Amazon	5000	TN	586	a68cec46ec7999c46fddd993df4f962b_		145.34 KB	image/jpeg	2023/586/02/a68cec46ec7999c46fddd993df4f962b_	202303/586/082/789/000001	83	2023-03-27 16:54:01	N
192	83	03	9159698082	0000000147	2023-02-08	poli	500	TN	586	ff396b9e57e6db6299a30a3b974fa2e8_		112.60 KB	image/jpeg	2023/586/02/ff396b9e57e6db6299a30a3b974fa2e8_	202303/586/082/147/000001	83	2023-03-27 17:01:06	N
221	88	03	9876543217	0000004234	2023-03-16	test shop	3454	TN	569	0db78238483e5f83ec385b088474acf9	\N	76.25 KB	application/pdf	2023/569/05/0db78238483e5f83ec385b088474acf9	202304/569/217/234/966920	88	2023-04-17 18:18:43	N
220	88	03	9876543217	0000000424	2023-03-12	cbe eta shop	345	TN	569	0ae73145dcbda8c79961d929e8661a05	\N	23.04 KB	application/pdf	2023/569/05/0ae73145dcbda8c79961d929e8661a05	202304/569/217/424/846107	88	2023-04-17 18:18:54	N
222	88	03	9876543217	0000007567	2023-03-07	ertert	5345	TN	569	7116bdf86fc847a9e8d53a430b219785	\N	23.04 KB	application/pdf	2023/569/03/7116bdf86fc847a9e8d53a430b219785	202304/569/217/567/552357	88	2023-04-17 18:19:20	N
223	88	03	9876543217	0000004235	2023-03-28	RTEWS	543	TN	569	d631ee4d149d1d354810711f90ddb485	\N	23.04 KB	application/pdf	2023/569/03/d631ee4d149d1d354810711f90ddb485	202304/569/217/235/812061	88	2023-04-17 18:19:33	N
239	92	6		72#$$	2023-04-21	pothes	8996	TN	578	5c1c1630cf7b18a88dafb3579ca111be_		105.91 KB	image/jpeg	2023/578/04/5c1c1630cf7b18a88dafb3579ca111be_	20/578/419/#$$/000001	92	2023-04-22 16:12:41	N
227	88	03	9876543217	0000456567	2023-03-21	Saravana Selva rathinam Store	545	TN	569	ba59b8ea6dc51b3b534a4e8e95d1a724	\N	23.04 KB	application/pdf	2023/569/03/ba59b8ea6dc51b3b534a4e8e95d1a724	202304/569/217/567/144014	88	2023-04-17 18:21:11	N
231	90	03	9876543221	0000000323	2023-03-09	terewr	344	TN	578	9824c033c2d4e5ebc7fa6dfbbfcdcc17	\N	270.51 KB	image/png	2023/578/03/9824c033c2d4e5ebc7fa6dfbbfcdcc17	202304/610/221/323/248505	90	2023-04-19 22:41:53	N
232	90	03	9876543221	0000004234	2023-03-23	tearfea	324	TN	578	ac14fe01155963e9c85d16f33a6c9a44	\N	270.51 KB	image/png	2023/578/03/ac14fe01155963e9c85d16f33a6c9a44	202304/610/221/234/776686	90	2023-04-19 22:42:23	N
233	90	03	9876543221	0000003443	2023-03-16	test	4324	TN	578	ad892e01575e595e951b1f45a3306f8a	\N	583.35 KB	image/png	2023/578/03/ad892e01575e595e951b1f45a3306f8a	202304/610/221/443/784684	90	2023-04-19 22:42:56	N
234	91	03	9876543222	0000023214	2023-03-07	ewtewr	45342	TN	578	17db6c7586c5382610302d944c8a17d3	\N	270.51 KB	image/png	2023/578/03/17db6c7586c5382610302d944c8a17d3	202304/578/222/214/415199	91	2023-04-19 22:45:07	N
\.


--
-- TOC entry 3602 (class 0 OID 45474)
-- Dependencies: 259
-- Data for Name: history_transactions; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.history_transactions (transhistory_id, transno, bill_user_id, forwarded_by, forwarded_to, forwarded_on, remarks, trans_status, process_code, forwardedby_role_action_code, forwardedto_role_action_code, bill_selection_id) FROM stdin;
\.


--
-- TOC entry 3559 (class 0 OID 44954)
-- Dependencies: 216
-- Data for Name: mst_charge; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_charge (chargeid, chargecode, chargedescription, divisioncode, zonecode, configcode, statusflag, createdby, updatedby, createdon, updatedon, roleid, distcode, circleid, roletypecode, roleactioncode) FROM stdin;
1	01	Nic Admin	\N	\N	\N	Y	\N	\N	\N	\N	13	\N	\N	01	01
2	\N	Citizen	\N	\N	\N	\N	\N	\N	\N	\N	20	\N	\N	06	06
17	\N	ADC	\N	\N	\N	\N	7	\N	2023-04-21 17:44:21.639447	\N	26	\N	\N	02	02
18	\N	CBE JC	08	\N	\N	\N	18	\N	2023-04-21 17:45:35.447372	\N	27	569	\N	03	03
19	\N	CBC DC	08	08	\N	\N	18	\N	2023-04-21 17:46:40.762947	\N	31	569	\N	04	04
20	\N	Pollachi DC	08	12	\N	\N	18	\N	2023-04-21 17:47:45.358277	\N	31	569	\N	04	04
21	\N	CBE AC	08	08	\N	\N	18	\N	2023-04-21 17:51:26.387382	\N	30	569	24	05	05
22	\N	Pollachi Ac	08	12	\N	\N	18	\N	2023-04-21 17:54:05.794847	\N	30	569	34	05	05
23	\N	Pollachi cto	08	12	\N	\N	18	\N	2023-04-21 17:58:55.246684	\N	1	569	35	07	07
24	\N	MDU JC	07	\N	\N	\N	18	\N	2023-04-21 18:07:39.239857	\N	27	578	\N	03	03
25	\N	MDU DC	07	06	\N	\N	25	\N	2023-04-21 18:11:10.90835	\N	31	578	\N	04	04
26	\N	AC Mdu kamarajar salai	07	06	\N	\N	26	\N	2023-04-21 18:15:42.457893	\N	30	578	19	05	05
27	\N	MDU KK Nagar	07	06	\N	\N	26	\N	2023-04-21 18:27:44.71337	\N	1	578	23	07	07
\.


--
-- TOC entry 3561 (class 0 OID 44958)
-- Dependencies: 218
-- Data for Name: mst_circle; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_circle (circlecode, circlename, divisioncode, zonecode, distcode, state_code, status_flag, createdby, createdon, updatedby, updatedon, circleid, roletypecode) FROM stdin;
21	Commericial Tax Officer, Chikkikulam	07	06	578	\N	\N	\N	\N	\N	\N	21	07
22	Commericial Tax Officer, Madurai Rula(East)	07	06	578	\N	\N	\N	\N	\N	\N	22	07
23	Commericial Tax Officer, KK Nagar	07	06	578	\N	\N	\N	\N	\N	\N	23	07
35	Commerical Tax, Valparai	08	12	569	\N	\N	\N	\N	\N	\N	35	07
01	Joint Commissioner(CS)	01	01	568	33	\N	\N	\N	\N	\N	1	05
02	Joint Commissioner(IT)	01	01	568	33	\N	\N	\N	\N	\N	2	05
03	Joint Commissioner(ST), Advance Ruling Authority	01	01	568	33	\N	\N	\N	\N	\N	3	05
04	Joint Commissioner(CT),Large Tax Payers Unit	02	01	568	33	\N	\N	\N	\N	\N	4	05
05	Deputy Commissioner(CT),LTU-I	02	01	568	33	\N	\N	\N	\N	\N	5	05
06	Deputy Commissioner(CT),LTU-II	02	01	568	33	\N	\N	\N	\N	\N	6	05
07	Deputy Commissioner(CT),LTU-III	02	01	568	33	\N	\N	\N	\N	\N	7	05
08	Deputy Commissioner(CT),LTU-IV	02	01	568	33	\N	\N	\N	\N	\N	8	05
09	Deputy Commissioner(CT),Zone-I	03	02	568	33	\N	\N	\N	\N	\N	10	05
17	Joint Commissioner(CT),Chennai(Central)	03	04	568	33	\N	\N	\N	\N	\N	14	05
18	Deputy Commissioner(CT),Zone-IV	03	04	568	33	\N	\N	\N	\N	\N	15	05
24	DR before DC(GST Appeal)	08	08	569	\N	\N	\N	\N	\N	\N	24	05
13	Assistant Commissioner(CT),Chennai(North)	03	02	568	33	\N	\N	\N	\N	\N	9	05
10	Assistant Commissioner(CT),Harbour	03	02	568	33	\N	\N	\N	\N	\N	11	05
11	Assistant Commissioner(CT),Vaallar Nagar	03	03	568	33	\N	\N	\N	\N	\N	12	05
12	Assistant Commissioner(CT),Chennai(North)	03	03	568	33	\N	\N	\N	\N	\N	13	05
14	Assistant Commissioner(CT),Annasalai	04	05	568	33	\N	\N	\N	\N	\N	16	05
15	Assistant Commissioner(CT),Kodungaiyur	04	05	568	33	\N	\N	\N	\N	\N	17	05
16	Assistant Commissioner(CT),Manali	04	05	568	33	\N	\N	\N	\N	\N	18	05
19	Assistant Commissioner(CT),Kamarajar Salai	07	06	578	\N	\N	\N	\N	\N	\N	19	05
20	Assistant Commissioner(CT),Vengalakadai Street	07	06	578	\N	\N	\N	\N	\N	\N	20	05
25	Assistant Commissioner(CT),RG Street	08	09	569	\N	\N	\N	\N	\N	\N	25	05
26	Assistant Commissioner(CT),Kunniyamuthur	08	09	569	\N	\N	\N	\N	\N	\N	26	05
27	Assistant Commissioner(CT),Avinashi	08	09	569	\N	\N	\N	\N	\N	\N	27	05
28	Assistant Commissioner(CT),Mettupalayam Road	08	10	569	\N	\N	\N	\N	\N	\N	28	05
30	Assistant Commissioner(CT),Gandhipuram	08	11	569	\N	\N	\N	\N	\N	\N	30	05
31	Assistant Commissioner(CT),Annur	08	11	569	\N	\N	\N	\N	\N	\N	31	05
32	Assistant Commissioner(CT), Avinashi Road	08	11	569	\N	\N	\N	\N	\N	\N	32	05
33	Assistant Commissioner(CT), Udumalpet(North)	08	12	569	\N	\N	\N	\N	\N	\N	33	05
34	Assistant Commissioner(CT), Pollachi	08	12	569	\N	\N	\N	\N	\N	\N	34	05
29	Assistant Commissioner(CT),Periya Naikan Palayam	08	10	569	\N	\N	\N	\N	\N	\N	29	05
\.


--
-- TOC entry 3564 (class 0 OID 44965)
-- Dependencies: 221
-- Data for Name: mst_config; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_config (schemecode, configcode, statecode, distcode, minimumbillamt, prizeamount, billentrystartdate, billentryenddate, billpurchasestartdate, billpurchaseenddate, billdrawdate, yymm, statusflag, createdby, createdon, updatedby, updatedon, allotment_status, finyear, finmonth, configid, allotmentby, allotmentdoneby, bill_selection_count) FROM stdin;
01	02	TN	610	10	500	2023-01-01 00:00:00	1970-01-01 00:00:00	2023-02-01 00:00:00	2023-02-28 00:00:00	\N	2210	\N	\N	\N	3	2023-04-21 17:28:14.919857	Y	2023	04	1	S	\N	1
01	03	TN	586	10	2000	2023-03-01 00:00:00	2023-03-30 00:00:00	2023-02-01 00:00:00	2023-02-28 00:00:00	2021-07-26 20:17:30.696395	2211	1	1	2021-07-26 20:17:30.696395	7	2023-04-12 12:02:21.362785	Y	2023	04	2	S	\N	1
01	4	TN	568	500	1000	2023-04-03 00:00:00	2023-04-05 00:00:00	2023-05-01 00:00:00	2023-04-05 00:00:00	\N	\N	\N	7	2023-04-11 18:39:06.608683	7	2023-04-11 18:54:24.636984	N	2023	04	4	S	\N	1
01	5	TN	569	10	1000	2023-04-01 00:00:00	2023-04-05 00:00:00	2023-03-01 00:00:00	2023-03-31 00:00:00	\N	\N	\N	3	2023-04-17 18:07:55.363099	3	2023-04-17 18:18:25.029127	Y	2023	04	6	S	\N	3
01	6	TN	578	20	5000	2023-04-01 00:00:00	2023-04-05 00:00:00	2023-03-01 00:00:00	2023-03-31 00:00:00	\N	\N	\N	3	2023-04-17 18:09:05.371414	3	2023-04-17 18:18:02.165088	Y	2023	04	7	S	\N	2
\.


--
-- TOC entry 3565 (class 0 OID 44972)
-- Dependencies: 222
-- Data for Name: mst_configlog; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_configlog (configlogid, configid, schemecode, configcode, statecode, distcode, minimumbillamt, prizeamount, billentrystartdate, billentryenddate, billpurchasestartdate, billpurchaseenddate, billdrawdate, yymm, statusflag, createdby, createdon, updatedby, updatedon) FROM stdin;
\.


--
-- TOC entry 3566 (class 0 OID 44975)
-- Dependencies: 223
-- Data for Name: mst_dept_user; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_dept_user (userid, email, pwd, name, mobilenumber, statecode, distcode, createdby, createdon, updatedby, updatedon, statusflag, profile_update, divisioncode, zonecode, circleid, dateofbirth, nodal, lott_executor, empid, roletypecode) FROM stdin;
21	pollachidc@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	Pollachi Dc	9876543125	TN	569	18	2023-04-21 17:49:03.236914	1	\N	t	Y	08	12	\N	2000-04-10	\N	\N	105	04
7	stateadmin@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	Nic Admin	9876543210	TN	\N	1	\N	1	\N	t	\N	\N	\N	\N	\N	N	N	\N	01
22	cbeac@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	Cbe Ac	9897645645	TN	569	18	2023-04-21 17:52:50.934477	1	\N	t	Y	08	08	24	1995-04-26	\N	\N	108	05
23	pollachiac@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	Pollachi Ac	9876545156	TN	569	18	2023-04-21 17:54:52.098756	1	\N	t	Y	08	12	34	1994-04-06	\N	\N	543	05
24	valparaicto@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	Pollachi Valparai Cto	9876455645	TN	569	18	2023-04-21 18:00:45.953514	1	\N	t	Y	08	12	35	1983-04-05	\N	\N	645	07
26	mdudc@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	Mdu Dc	9897496465	TN	578	25	2023-04-21 18:11:52.566331	1	\N	t	Y	07	06	\N	2001-04-03	\N	\N	5345	04
28	kknagarcto@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	Mdu Kk Nagar	9879464642	TN	578	26	2023-04-21 18:32:35.517194	1	\N	t	Y	07	06	23	1992-04-22	\N	\N	4325	07
25	mdujc@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	Mdu Jc	9875456454	TN	578	18	2023-04-21 18:07:26.518803	7	2023-04-24 16:09:52.932778	t	Y	07	\N	\N	1993-04-28	Y	\N	987	03
27	mduac@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	Ac  Kamarajar Salai	9897945645	TN	578	26	2023-04-21 18:19:29.157689	26	2023-04-21 18:23:51.061125	t	Y	07	06	19	1995-04-18	\N	\N	596	05
18	adc@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	Adc	9876543211	TN		7	2023-04-21 17:44:57.320379	1	\N	t	Y	\N	\N	\N	1995-04-11	\N	\N	100	02
19	cbejc@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	Cbe Jc	9876543212	TN	569	18	2023-04-21 17:46:06.310067	1	\N	t	Y	08	\N	\N	1978-04-24	\N	\N	102	03
20	cbedc@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	Cbe Dc	9876543214	TN	569	18	2023-04-21 17:47:11.411193	1	\N	t	Y	08	08	\N	1996-04-09	\N	\N	103	04
\.


--
-- TOC entry 3568 (class 0 OID 44983)
-- Dependencies: 225
-- Data for Name: mst_district; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_district (distid, distcode, statecode, distename, flag, createdon, createdby, updatedby, updatedon) FROM stdin;
123	589	TN	Tiruvallur	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
98	568	TN	Chennai	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
104	574	TN	Kanchipuram	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
126	595	TN	Vellore	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
101	571	TN	Dharmapuri	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
124	593	TN	Tiruvannamalai	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
127	596	TN	Viluppuram	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
115	584	TN	Salem	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
110	580	TN	Namakkal	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
103	573	TN	Erode	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
111	587	TN	Nilgiris	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
99	569	TN	Coimbatore	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
102	572	TN	Dindigul	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
106	576	TN	Karur	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
120	591	TN	Tiruchirappalli	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
112	581	TN	Perambalur	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
97	610	TN	Ariyalur	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
100	570	TN	Cuddalore	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
109	579	TN	Nagapattinam	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
125	590	TN	Tiruvarur	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
117	586	TN	Thanjavur	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
113	582	TN	Pudukkottai	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
116	585	TN	Sivaganga	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
108	578	TN	Madurai	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
118	588	TN	Theni	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
128	597	TN	Virudhunagar	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
114	583	TN	Ramanathapuram	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
119	594	TN	Thoothukudi (Tuticorin)	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
121	592	TN	Tirunelveli	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
105	575	TN	Kanyakumari	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
107	577	TN	Krishnagiri	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
122	634	TN	Tiruppur	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
\.


--
-- TOC entry 3569 (class 0 OID 44986)
-- Dependencies: 226
-- Data for Name: mst_division; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_division (divisionid, divisioncode, divisionsname, divisionlname, statecode, statusflag, createdby, createdon, updatedby, updatedon) FROM stdin;
1	01	OOCCT	Office Of the Commissioner of Commerical Taxes	\N	Y	\N	\N	\N	\N
2	02	LTU	Large Taxpayers Unit	\N	Y	\N	\N	\N	\N
3	03	CH(N)	Chennai (North)	\N	Y	\N	\N	\N	\N
4	04	CH(C)	Chennai (Central)	\N	Y	\N	\N	\N	\N
1	05	Ariyalur	Ariyalur	\N	Y	\N	\N	\N	\N
2	06	Thanjavur	Thanjavur	\N	Y	\N	\N	\N	\N
3	07	MDU	Madurai	\N	Y	\N	\N	\N	\N
4	08	Coimbatore	Coimbatore	\N	Y	\N	\N	\N	\N
\.


--
-- TOC entry 3572 (class 0 OID 44993)
-- Dependencies: 229
-- Data for Name: mst_menu; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_menu (statecode, menuname, levelid, parentid, menuurl, status, createdby, createdon, updatedby, updatedon, key, order_id, menuid) FROM stdin;
\N	Menus	2	13	Mybill/menu	Y	1	2023-03-03 03:12:35.614851	\N	\N	menu	2	14
\N	Roles	2	13	Mybill/role	Y	1	2023-03-03 03:12:57.430924	\N	\N	role	1	15
\N	Manage Role	2	13	Mybill/manage_role	Y	1	2023-03-05 06:09:02.012195	1	2023-03-05 06:46:51.820469	manage_role	3	16
\N	Update_Nodal	2	22	Mybill/update_nodal	Y	1	2023-04-11 17:28:08.428466	\N	\N	update_nodal	2	23
\N	Settings	2	22	Mybill/configuration_settings	Y	1	2023-03-21 03:44:42.809417	\N	\N	settings	1	21
\N	View Assigned Charge	2	6	Mybill/view_usercharge	Y	1	2023-04-12 12:07:39.757476	\N	\N	view_usercharge	\N	26
\N	Unassign Charge	2	6	Mybill/unassign_charge	N	1	2023-03-02 04:19:47.872702	\N	\N	unassign_charge	\N	17
\N	Additional Charge	2	6	Mybill/additional_charge	N	1	2023-03-02 04:20:23.04084	\N	\N	additional_charge	\N	18
\N	Approved Details	2	24	Mybill/verify_allotment	Y	1	2023-04-20 12:18:23.179204	1	2023-04-25 14:47:06.37088	verify_allotment	\N	27
\N	Allotment Details	1	0	Mybill/allotment	Y	1	2023-04-11 17:29:26.072359	1	2023-04-25 14:49:54.527762	allotment	6	24
\N	Billing Details	1	\N	Mybill/billing_details	Y	1	2023-03-02 04:07:44.687977	\N	\N	billing_details	2	1
\N	Account Details	1	\N	Mybill/Account Details	Y	1	2023-03-02 04:12:19.782143	\N	\N	account_details	7	4
\N	User Management	1	0	Mybill/UserManagment	Y	1	2023-03-01 21:39:53.901979	1	2023-03-02 04:16:28.2884	user_management	3	6
\N	Dashboard	1	0	Mybill/citizen_dashboard	Y	1	2023-03-02 04:33:18.139899	1	2023-03-02 04:33:33.034963	citizen_dash	1	11
\N	Dashboard	1	\N	Mybill/dashboard	Y	1	2023-03-02 04:34:04.1476	\N	\N	dashboard	1	12
\N	Menu & Roles	1	\N	Mybill	Y	1	2023-03-03 03:12:11.67196	\N	\N	menu_role	4	13
\N	Configuration	1	\N	Mybill/configuration	Y	1	2023-03-21 03:44:15.125496	\N	\N	configuration	5	22
\N	My Bill	2	1	Mybill/mybill	Y	1	2023-03-02 04:08:54.849724	\N	\N	mybill	1	2
\N	Bill History	2	1	Mybill/bill_history	Y	1	2023-03-02 04:09:36.010054	\N	\N	bill_history	2	3
\N	Profile	2	4	Mybill/profile	Y	1	2023-03-02 04:14:08.717483	\N	\N	profile	1	5
\N	Change Password	2	4	Mybill/change_password	Y	1	2023-03-02 04:16:51.088822	1	2023-03-02 04:19:38.008784	change_password	2	10
\N	Create User	2	6	Mybill/create_user	Y	1	2023-03-01 21:46:32.956883	1	2023-03-02 04:16:51.976141	create_user	2	7
\N	Assign Charge	2	6	Mybill/assign_charge	Y	1	2023-03-02 04:19:13.867966	\N	\N	assign_charge	3	9
\N	View User	2	6	Mybill/view_user	Y	1	2023-03-20 05:47:57.974374	\N	\N	view_user	4	19
\N	View Charge	2	6	Mybill/view_charge	Y	1	2023-03-20 05:48:24.14594	\N	\N	view_charge	5	20
\N	Create charge	2	6	Mybill/create_charge	Y	1	2023-03-02 04:17:51.85518	\N	\N	create_charge	1	8
\N	Allotment Tab	1	\N	Mybill/allotment_tab	Y	1	2023-05-02 16:41:26.982814	\N	\N	allotment_tab	\N	28
\N	Process Allotment	2	24	Mybill/selection_allotment	Y	1	2023-04-11 17:32:10.958207	1	2023-05-05 11:44:27.878477	selection_allotment	1	25
\N	Test Allotment	2	24	Mybill/test_allotment	Y	1	2023-05-05 11:45:21.572513	\N	\N	test_allotment	\N	29
\.


--
-- TOC entry 3573 (class 0 OID 44997)
-- Dependencies: 230
-- Data for Name: mst_menu_mapping; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_menu_mapping (menuid, roleid, control_json) FROM stdin;
20	20	{"1": ["3", "2", "5", 11]}
13	13	{"1": ["9", "8", "7", "25", "16", "14", "15", "21", "23", "26", "20", "19", 12]}
1	1	{"1": ["10", "5", 12]}
27	27	{"1": ["25", "27", "9", "10", "8", "7", "5", "26", "20", "19", 12]}
30	31	{"1": ["27", "9", "10", "8", "7", "25", "5", "26", "20", "19", 12]}
29	30	{"1": ["27", "10", "25", "5", 12]}
26	26	{"1": ["27", "9", "10", "8", "7", "16", "14", "25", "5", "15", "21", "29", "23", "26", "20", "19", 12]}
\.


--
-- TOC entry 3575 (class 0 OID 45003)
-- Dependencies: 232
-- Data for Name: mst_role; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_role (roleid, statecode, rolesname, rolelname, status, createdby, createdon, updatedby, updatedon, usertypecode, roletypecode, roleactioncode) FROM stdin;
13	33	Nic Admin	\N	Y	1	2023-03-16 00:34:17.622117	\N	\N	02	01	01
20	33	Citizen	\N	Y	1	2023-03-19 21:57:40.414574	\N	\N	01	06	06
26	33	ADC	\N	Y	1	2023-03-19 23:47:39.125557	\N	\N	02	02	02
27	33	JC 	\N	Y	1	2023-03-20 00:18:53.439474	\N	\N	02	03	03
30	33	AC	\N	Y	1	2023-03-20 04:33:28.672021	\N	\N	02	05	05
31	33	DC	\N	Y	1	2023-03-20 21:51:05.569915	\N	\N	02	04	04
1	33	CTO	\N	Y	1	2023-04-19 10:57:44.960162	\N	\N	02	07	07
\.


--
-- TOC entry 3577 (class 0 OID 45007)
-- Dependencies: 234
-- Data for Name: mst_roleaction; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_roleaction (roleactioncode, roleactionsname, roleactionlname, statusflag, createdby, createdon, updatedby, updatedon, roletypecode, roleactionid) FROM stdin;
02	ADC	Additional Commissioner 	Y	1	23:19:18.631824	1	23:19:18.631824	02	1
03	JC	Joint Commissioner 	Y	1	23:19:41.38166	1	23:19:41.38166	03	2
04	DC	Deputy Commissioner 	Y	1	23:20:02.468652	1	23:20:02.468652	04	3
05	AC	Assistant Commissioner	Y	1	23:20:21.707182	1	23:20:21.707182	05	4
06	C	Citizen	Y	1	23:20:38.521665	1	23:20:38.521665	06	5
07	CTO	Commerical Tax Officer	Y	1	16:33:06.5064	1	16:33:06.5064	07	7
01	Nic	State Admin	\N	\N	\N	\N	\N	01	6
\.


--
-- TOC entry 3579 (class 0 OID 45011)
-- Dependencies: 236
-- Data for Name: mst_roletype; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_roletype (roletypecode, roletypelname, statusflag, createdby, createdon, updatedby, updatedon, usertypecode, roletypeid) FROM stdin;
02	Additional Commissioner	Y	1	2023-03-15 22:32:09.473697	1	2023-03-15 22:32:09.473697	02	1
03	Joint Commissioner	Y	1	2023-03-15 22:32:33.078455	1	2023-03-15 22:32:33.078455	02	2
04	Deputy Commissioner	Y	1	2023-03-15 22:32:39.861276	1	2023-03-15 22:32:39.861276	02	6
07	Commerical Tax Officer	Y	1	2023-04-11 15:45:34.394972	1	2023-04-11 15:45:34.394972	02	7
05	Assistant Commissioner	Y	1	2023-03-15 22:32:50.256706	1	2023-03-15 22:32:50.256706	02	3
06	Citizen	Y	1	2023-03-15 22:33:18.240964	1	2023-03-15 22:33:18.240964	01	5
01	State Admin	N	1	2023-03-15 22:31:31.40468	1	2023-03-15 22:31:31.40468	02	4
\.


--
-- TOC entry 3581 (class 0 OID 45015)
-- Dependencies: 238
-- Data for Name: mst_scheme; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_scheme (schemeid, schemecode, schemesname, schemelname, minimumbillamt, prizeamount, billentrystartdate, billentryenddate, billpurchasestartdate, billpurchaseenddate, billdrawdate, finyear, statusflag, yymm, configstate_dist, createdby, createdon, updatedby, updatedon, statecode) FROM stdin;
1	01	MyBill	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	202210	1	\N	\N	\N	\N	TN
\.


--
-- TOC entry 3582 (class 0 OID 45018)
-- Dependencies: 239
-- Data for Name: mst_state; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_state (stateid, statecode, stateename, statetname, stateut, flag, createdon, createdby, updatedby, updatedon) FROM stdin;
49	TN	Tamil Nadu	தமிழ்நாடு	0	0	2022-10-14 14:45:37	1	1	2022-10-14 14:45:37
\.


--
-- TOC entry 3583 (class 0 OID 45021)
-- Dependencies: 240
-- Data for Name: mst_user; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_user (userid, schemecode, email, pwd, name, mobilenumber, statecode, distcode, ipaddress, deviceid, addr1, addr2, pincode, createdby, createdon, updatedby, updatedon, statusflag, profile_update, chargeid, roleid, roletypecode) FROM stdin;
80	01	test@gmail.com	827ccb0eea8a706c4c34a16891f84e7b	Rahmath	9884778378	TN	610	127.0.0.1	W	test test test	test test test	600012	1	2023-02-21 01:56:42	80	2023-02-20 16:59:06.947114	t	Y	\N	\N	\N
81	01	Cherna@kkk.cd	b075d9af3f15e709616e0084376f0219	Siva	6666666666	TN	572	10.163.19.153	W	sdasasdasdasdas	asdasdasasdas	600000	1	2023-02-21 21:53:19	81	2023-02-21 12:53:51.617895	t	Y	\N	\N	\N
93	01	chennai@gmail.com	0e7517141fb53f21ee439b355b5a1d0a	stalin bsnl	9150743363	TN	568	192.0.0.177	M	Bharathiyar street,laxipuram,thiruvanmiyur	Address 2	612201	1	2023-04-30 23:12:00	1	2023-04-30 23:12:00	t	\N	2	20	06
84	01	rahamath.chennai@gmail.com	a3876fafbc8b9b9d3820b6e3a610e3d2	Nisha	9884253079	TN	568	192.0.0.177	M	Address 1	Address 2	600000	1	2023-03-21 17:21:16	1	2023-03-21 17:21:16	t	\N	\N	\N	\N
79	01	sivaeceerd@gmail.com	0e7517141fb53f21ee439b355b5a1d0a	siva	8148958988	TN	610	127.0.0.1	W	karungal palayam	cauvery road	638003	1	2023-02-17 19:40:37	79	2023-02-20 16:02:34.733488	t	Y	\N	\N	\N
86	01	anitha96880@gmail.com	d9aa68ff2a28a157eeb3ad26362adbe4	Anita	6383839415	TN	610	192.0.0.177	M	main road,suthamalli.	Address 2	621804	1	2023-03-26 08:31:49	1	2023-03-26 08:31:49	t	\N	\N	\N	\N
85	01	swathinagarajann99@gmail.com	e801ebc30a494503e7ba8fc001764c8d	swathi	9487687827	TN	597	10.163.19.176	W	kattaiyapuram	virudhunagar	626001	1	2023-03-24 12:36:35	85	2023-03-27 11:44:45.101007	t	Y	2	20	06
83	01	stalingalaxy@gmail.com	0e7517141fb53f21ee439b355b5a1d0a	Stalin Thomas	9159698082	TN	586	192.0.0.177	M	milagay pattam street,vadagarai,kumbakonam(t.k)	Address 2	612201	1	2023-03-10 15:54:07	1	2023-03-10 15:54:07	t	\N	\N	\N	\N
87	01	sivaeceerd@gmail.com	8907fc2282ea176b029fd7819a83dc2f	siva	9080076157	TN	610	192.0.0.177	M	12 Raja St	Annamalaipuram Chennai	600012	1	2023-03-28 11:46:34	87	2023-03-28 17:21:29.569076	t	Y	2	20	06
88	01	cbeuser@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	cbe user	9876543217	TN	569	10.163.19.173	W	cheranma nagar	hope college	638006	1	2023-04-17 17:58:28	88	2023-04-17 17:58:59.421457	t	Y	2	20	06
89	01	sivaeceerd@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	siva	9876543219	TN	569	10.163.19.173	W	cheranma nagar	coimbatore	697884	1	2023-04-18 11:57:28	89	2023-04-18 11:58:02.55315	t	Y	2	20	06
90	01	test1@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	userone	9876543221	TN	610	223.187.113.95	W	test user one	test user one	584874	1	2023-04-19 22:41:04	90	2023-04-19 22:41:36.732241	t	Y	2	20	06
91	01	testuser2@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	usertwo	9876543222	TN	578	223.187.113.95	W	ewrewrewrewr	wtwetwewrwer	484525	1	2023-04-19 22:44:28	91	2023-04-19 22:44:49.162364	t	Y	2	20	06
92	01	abc@gmail.com	f925916e2754e5e03f75dd58a5733251	test	9638527419	TN	578	192.0.0.177	M	Kattaiyapuram	Virudhunagar	626001	1	2023-04-22 16:00:50	92	2023-04-22 16:07:11.333343	t	Y	2	20	06
\.


--
-- TOC entry 3584 (class 0 OID 45034)
-- Dependencies: 241
-- Data for Name: mst_user_charge; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_user_charge (userchargeid, statecode, userid, divisioncode, zonecode, configcode, charge_from, statusflag, createdby, createdon, updatedby, updatedon, chargeid, roleid, circleid, distcode, roletypecode) FROM stdin;
1	33	7	\N	\N	\N	2023-03-03	Y	\N	\N	\N	\N	1	13	\N	\N	01
18	TN	18	\N	\N	\N	2023-04-21	Y	7	2023-04-21 17:45:05.109287	\N	\N	17	26	\N	\N	02
19	TN	19	08	\N	\N	2023-04-21	Y	18	2023-04-21 17:46:13.344839	\N	\N	18	27	\N	569	03
20	TN	20	08	08	\N	2023-04-21	Y	18	2023-04-21 17:47:19.623449	\N	\N	19	31	\N	569	04
21	TN	21	08	12	\N	2023-04-21	Y	18	2023-04-21 17:49:10.93199	\N	\N	20	31	\N	569	04
22	TN	22	08	08	\N	2023-04-21	Y	18	2023-04-21 17:52:57.78532	\N	\N	21	30	24	569	05
23	TN	23	08	12	\N	2023-04-21	Y	18	2023-04-21 17:54:58.878711	\N	\N	22	30	34	569	05
24	TN	24	\N	\N	\N	2023-04-21	Y	18	2023-04-21 18:00:53.170118	\N	\N	23	1	\N	\N	07
25	TN	25	07	\N	\N	2023-04-21	Y	18	2023-04-21 18:07:46.107282	\N	\N	24	27	\N	578	03
26	TN	26	07	06	\N	2023-04-21	Y	25	2023-04-21 18:11:58.395705	\N	\N	25	31	\N	578	04
27	TN	27	07	06	\N	2023-04-21	Y	26	2023-04-21 18:25:00.108701	\N	\N	26	30	19	578	05
28	TN	28	\N	\N	\N	2023-04-21	Y	26	2023-04-21 18:32:45.95173	\N	\N	27	1	\N	\N	07
\.


--
-- TOC entry 3587 (class 0 OID 45039)
-- Dependencies: 244
-- Data for Name: mst_userlog; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_userlog (userlogid, userid, schemecode, email, pwd, name, mobilenumber, statusflag, statecode, distcode, ipaddress, deviceid, addr1, adr2, pincode, createdby, createdon, updatedby, updatedon) FROM stdin;
1	85	01	swathinagarajann99@gmail.com	e801ebc30a494503e7ba8fc001764c8d	swathi	9487687827	1	TN	597	10.163.19.176	W	\N	\N	\N	1	2023-03-24 12:36:35	1	2023-03-24 12:36:35
2	85	01	swathinagarajann99@gmail.com	e801ebc30a494503e7ba8fc001764c8d	swathi	9487687827	1	TN	597	10.163.19.176	W	\N	\N	\N	1	2023-03-24 12:36:35	85	2023-03-24 12:55:44.011177
3	85	01	swathinagarajann99@gmail.com	e801ebc30a494503e7ba8fc001764c8d	swathi	9487687827	1	TN	597	10.163.19.176	W	\N	\N	\N	1	2023-03-24 12:36:35	85	2023-03-24 13:21:18.294371
4	85	01	swathinagarajann99@gmail.com	e801ebc30a494503e7ba8fc001764c8d	swathi	9487687827	1	TN	597	10.163.19.176	W	\N	\N	\N	1	2023-03-24 12:36:35	85	2023-03-24 13:21:36.426412
5	87	01	sivaeceerd@gmail.com	8907fc2282ea176b029fd7819a83dc2f	siva	9080076157	1	TN	610	192.0.0.177	M	\N	\N	\N	1	2023-03-28 11:46:34	1	2023-03-28 11:46:34
6	87	01	sivaeceerd@gmail.com	8907fc2282ea176b029fd7819a83dc2f	siva	9080076157	1	TN	610	192.0.0.177	M	\N	\N	\N	1	2023-03-28 11:46:34	87	2023-03-28 11:49:56.429167
7	88	01	cbeuser@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	cbe user	9876543217	1	TN	569	10.163.19.173	W	\N	\N	\N	1	2023-04-17 17:58:28	1	2023-04-17 17:58:28
8	89	01	sivaeceerd@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	siva	9876543219	1	TN	569	10.163.19.173	W	\N	\N	\N	1	2023-04-18 11:57:28	1	2023-04-18 11:57:28
9	90	01	test1@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	userone	9876543221	1	TN	610	223.187.113.95	W	\N	\N	\N	1	2023-04-19 22:41:04	1	2023-04-19 22:41:04
10	91	01	testuser2@gmail.com	cc03e747a6afbbcbf8be7668acfebee5	usertwo	9876543222	1	TN	578	223.187.113.95	W	\N	\N	\N	1	2023-04-19 22:44:28	1	2023-04-19 22:44:28
11	92	01	abc@gmail.com	f925916e2754e5e03f75dd58a5733251	test	9638527419	1	TN	578	192.0.0.177	M	\N	\N	\N	1	2023-04-22 16:00:50	1	2023-04-22 16:00:50
\.


--
-- TOC entry 3589 (class 0 OID 45048)
-- Dependencies: 246
-- Data for Name: mst_userlogindetail; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_userlogindetail (userid, mobilenumber, ipaddress, deviceid, logintime, logouttime, logoutstatus, userloginid) FROM stdin;
79	8148958988	10.163.19.176	W	2023-02-21 17:14:26	2023-02-21 22:17:32.996242	0	101
79	8148958988	10.163.19.176	W	2023-02-20 22:40:52	2023-02-21 22:17:32.996242	0	89
79	8148958988	10.163.19.176	W	2023-02-21 21:50:32	2023-02-21 22:17:32.996242	0	83
79	8148958988	10.163.19.176	W	2023-02-21 21:30:20	2023-02-21 22:17:32.996242	0	80
79	8148958988	10.163.19.176	W	2023-02-21 21:14:14	2023-02-21 22:17:32.996242	0	78
79	8148958988	127.0.0.1	W	2023-02-21 19:24:38	2023-02-21 22:17:32.996242	0	73
79	8148958988	::1	W	2023-02-21 19:44:36	2023-02-21 22:17:32.996242	0	75
79	8148958988	127.0.0.1	W	2023-02-21 19:22:52	2023-02-21 22:17:32.996242	0	71
79	8148958988	127.0.0.1	W	2023-02-21 01:33:37	2023-02-21 22:17:32.996242	0	68
79	8148958988	10.163.19.176	W	2023-02-20 21:34:18	2023-02-21 22:17:32.996242	0	62
79	8148958988	10.163.19.176	W	2023-02-20 21:34:51	2023-02-21 22:17:32.996242	0	64
79	8148958988	127.0.0.1	W	2023-02-20 21:12:48	2023-02-21 22:17:32.996242	0	58
79	8148958988	10.163.19.173	W	2023-02-20 21:20:24	2023-02-21 22:17:32.996242	0	60
79	8148958988	127.0.0.1	W	2023-02-17 19:40:49	2023-02-21 22:17:32.996242	0	13
79	8148958988	127.0.0.1	W	2023-02-17 21:52:36	2023-02-21 22:17:32.996242	0	14
79	8148958988	127.0.0.1	W	2023-02-17 22:23:27	2023-02-21 22:17:32.996242	0	15
79	8148958988	127.0.0.1	W	2023-02-17 23:30:22	2023-02-21 22:17:32.996242	0	16
79	8148958988	127.0.0.1	W	2023-02-17 23:43:42	2023-02-21 22:17:32.996242	0	17
79	8148958988	10.163.19.176	W	2023-02-22 08:40:59	\N	1	102
81	6666666666	10.163.19.153	W	2023-02-21 21:53:30	2023-02-21 12:54:11.256307	0	85
79	8148958988	10.163.19.176	W	2023-02-20 22:48:45	2023-02-21 22:17:32.996242	0	90
79	8148958988	10.163.19.176	W	2023-02-21 21:52:27	2023-02-21 22:17:32.996242	0	84
79	8148958988	::1	W	2023-02-21 19:44:36	2023-02-21 22:17:32.996242	0	74
79	8148958988	127.0.0.1	W	2023-02-21 19:45:17	2023-02-21 22:17:32.996242	0	76
79	8148958988	10.163.19.176	W	2023-02-20 21:34:35	2023-02-21 22:17:32.996242	0	63
79	8148958988	127.0.0.1	W	2023-02-20 21:35:25	2023-02-21 22:17:32.996242	0	65
79	8148958988	10.163.19.176	W	2023-02-18 00:06:20	2023-02-21 22:17:32.996242	0	25
79	8148958988	10.163.19.176	W	2023-02-18 00:13:12	2023-02-21 22:17:32.996242	0	26
79	8148958988	10.163.19.176	W	2023-02-18 02:11:59	2023-02-21 22:17:32.996242	0	27
79	8148958988	10.163.19.176	W	2023-02-18 02:12:11	2023-02-21 22:17:32.996242	0	28
79	8148958988	10.163.19.176	W	2023-02-18 02:12:32	2023-02-21 22:17:32.996242	0	29
79	8148958988	10.163.19.176	W	2023-02-18 02:12:36	2023-02-21 22:17:32.996242	0	30
79	8148958988	10.163.19.176	W	2023-02-18 02:12:55	2023-02-21 22:17:32.996242	0	31
79	8148958988	10.163.19.176	W	2023-02-18 02:12:59	2023-02-21 22:17:32.996242	0	32
79	8148958988	127.0.0.1	W	2023-02-18 02:15:17	2023-02-21 22:17:32.996242	0	33
80	9884778378	127.0.0.1	W	2023-02-21 01:58:40	\N	1	69
79	8148958988	127.0.0.1	W	2023-02-18 02:31:51	2023-02-21 22:17:32.996242	0	34
79	8148958988	127.0.0.1	W	2023-02-18 02:33:54	2023-02-21 22:17:32.996242	0	35
79	8148958988	127.0.0.1	W	2023-02-18 02:39:43	2023-02-21 22:17:32.996242	0	36
79	8148958988	127.0.0.1	W	2023-02-18 02:42:54	2023-02-21 22:17:32.996242	0	37
79	8148958988	127.0.0.1	W	2023-02-18 02:55:48	2023-02-21 22:17:32.996242	0	38
79	8148958988	127.0.0.1	W	2023-02-18 03:00:49	2023-02-21 22:17:32.996242	0	39
79	8148958988	127.0.0.1	W	2023-02-20 19:09:00	2023-02-21 22:17:32.996242	0	40
79	8148958988	127.0.0.1	W	2023-02-20 19:52:36	2023-02-21 22:17:32.996242	0	41
79	8148958988	10.163.19.176	W	2023-02-20 20:54:54	2023-02-21 22:17:32.996242	0	42
79	8148958988	10.163.19.176	W	2023-02-20 20:55:02	2023-02-21 22:17:32.996242	0	43
79	8148958988	10.163.19.176	W	2023-02-20 20:55:21	2023-02-21 22:17:32.996242	0	44
79	8148958988	10.163.19.176	W	2023-02-20 20:55:34	2023-02-21 22:17:32.996242	0	45
79	8148958988	10.163.19.176	W	2023-02-20 20:55:50	2023-02-21 22:17:32.996242	0	46
79	8148958988	10.163.19.176	W	2023-02-20 20:56:35	2023-02-21 22:17:32.996242	0	47
79	8148958988	10.163.19.176	W	2023-02-20 20:57:05	2023-02-21 22:17:32.996242	0	48
79	8148958988	10.163.19.148	W	2023-02-21 21:54:56	2023-02-21 22:17:32.996242	0	86
79	8148958988	10.163.19.148	W	2023-02-21 22:21:12	2023-02-21 22:17:32.996242	0	88
79	8148958988	10.163.19.176	W	2023-02-20 20:57:37	2023-02-21 22:17:32.996242	0	49
79	8148958988	127.0.0.1	W	2023-02-20 20:58:21	2023-02-21 22:17:32.996242	0	50
79	8148958988	127.0.0.1	W	2023-02-20 20:58:27	2023-02-21 22:17:32.996242	0	51
79	8148958988	127.0.0.1	W	2023-02-20 20:58:32	2023-02-21 22:17:32.996242	0	52
79	8148958988	127.0.0.1	W	2023-02-20 22:31:32	2023-02-21 22:17:32.996242	0	67
79	8148958988	127.0.0.1	W	2023-02-17 23:51:19	2023-02-21 22:17:32.996242	0	18
79	8148958988	10.163.19.173	W	2023-02-18 00:02:26	2023-02-21 22:17:32.996242	0	19
79	8148958988	10.163.19.173	W	2023-02-18 00:02:39	2023-02-21 22:17:32.996242	0	20
79	8148958988	::1	W	2023-02-18 00:04:14	2023-02-21 22:17:32.996242	0	21
79	8148958988	10.163.19.176	W	2023-02-18 00:05:01	2023-02-21 22:17:32.996242	0	22
79	8148958988	10.163.19.176	W	2023-02-18 00:05:53	2023-02-21 22:17:32.996242	0	23
79	8148958988	10.163.19.176	W	2023-02-18 00:06:05	2023-02-21 22:17:32.996242	0	24
79	8148958988	127.0.0.1	W	2023-02-20 21:00:34	2023-02-21 22:17:32.996242	0	53
79	8148958988	127.0.0.1	W	2023-02-20 21:01:02	2023-02-21 22:17:32.996242	0	54
79	8148958988	127.0.0.1	W	2023-02-20 21:04:14	2023-02-21 22:17:32.996242	0	55
79	8148958988	127.0.0.1	W	2023-02-20 21:08:45	2023-02-21 22:17:32.996242	0	56
79	8148958988	10.163.19.148	W	2023-02-21 22:10:28	2023-02-21 22:17:32.996242	0	87
79	8148958988	127.0.0.1	W	2023-02-20 21:08:59	2023-02-21 22:17:32.996242	0	57
79	8148958988	10.163.19.173	W	2023-02-20 21:19:13	2023-02-21 22:17:32.996242	0	59
79	8148958988	10.163.19.176	W	2023-02-21 21:43:35	2023-02-21 22:17:32.996242	0	82
79	8148958988	127.0.0.1	W	2023-02-20 21:25:54	2023-02-21 22:17:32.996242	0	61
79	8148958988	127.0.0.1	W	2023-02-20 21:40:55	2023-02-21 22:17:32.996242	0	66
79	8148958988	10.163.19.176	W	2023-02-21 21:22:58	2023-02-21 22:17:32.996242	0	79
79	8148958988	127.0.0.1	W	2023-02-21 19:15:11	2023-02-21 22:17:32.996242	0	70
79	8148958988	127.0.0.1	W	2023-02-21 19:23:19	2023-02-21 22:17:32.996242	0	72
79	8148958988	127.0.0.1	W	2023-02-21 20:16:08	2023-02-21 22:17:32.996242	0	77
79	8148958988	10.163.19.176	W	2023-02-20 23:24:28	2023-02-21 22:17:32.996242	0	91
79	8148958988	10.163.19.176	W	2023-02-20 23:36:21	2023-02-21 22:17:32.996242	0	93
79	8148958988	10.163.19.176	W	2023-02-21 21:35:56	2023-02-21 22:17:32.996242	0	81
79	8148958988	10.163.19.176	W	2023-02-20 23:28:45	2023-02-21 22:17:32.996242	0	92
79	8148958988	10.163.19.176	W	2023-02-21 00:18:04	2023-02-21 22:17:32.996242	0	94
79	8148958988	10.163.19.176	W	2023-02-21 00:41:09	2023-02-21 22:17:32.996242	0	95
79	8148958988	10.163.19.176	W	2023-02-21 00:45:32	2023-02-21 22:17:32.996242	0	96
79	8148958988	10.163.19.176	W	2023-02-21 00:51:12	2023-02-21 22:17:32.996242	0	97
79	8148958988	10.163.19.148	W	2023-02-21 01:02:21	2023-02-21 22:17:32.996242	0	98
79	8148958988	10.163.19.148	W	2023-02-21 01:08:04	2023-02-21 22:17:32.996242	0	99
79	8148958988	10.163.19.176	W	2023-02-21 01:45:01	2023-02-21 22:17:32.996242	0	100
83	9159698082	10.163.19.176	W	2023-03-23 12:04:44	\N	1	103
83	9159698082	10.163.19.176	W	2023-03-23 12:11:57	\N	1	104
83	9159698082	10.163.2.160	W	2023-03-24 10:42:44	\N	1	105
79	8148958988	10.163.2.160	W	2023-03-24 10:49:17	\N	1	106
79	8148958988	10.163.2.160	W	2023-03-24 12:27:35	\N	1	107
79	8148958988	10.163.19.176	W	2023-03-24 12:33:21	\N	1	108
3	9876543211	10.163.19.176	W	2023-04-21 16:25:57	\N	1	438
3	9876543211	10.163.2.160	W	2023-04-21 17:13:33	\N	1	439
2	1234567890	10.163.19.173	W	2023-04-11 17:34:02	2023-04-11 17:34:55.171428	0	158
1	9876543225	10.163.2.227	W	2023-04-19 15:24:31	2023-04-21 15:50:35.501731	0	321
79	8148958988	10.163.19.173	W	2023-03-24 14:56:22	\N	1	117
79	8148958988	10.163.19.173	W	2023-03-27 11:06:58	\N	1	123
1	9876543225	10.163.2.160	W	2023-04-18 10:14:34	2023-04-21 15:50:35.501731	0	244
4	9876543212	10.163.2.227	W	2023-04-17 16:11:00	2023-04-17 16:11:29.546952	0	224
3	9876543211	10.163.19.176	W	2023-04-21 17:27:54	\N	1	440
83	9159698082	10.163.19.176	W	2023-03-27 15:52:03	\N	1	131
13	9456454541	10.163.2.160	W	2023-04-20 11:12:52	2023-04-20 11:41:19.656244	0	371
10	9879685645	10.163.19.173	W	2023-04-17 17:55:27	2023-04-21 15:56:02.824888	0	234
89	9876543219	10.163.19.173	W	2023-04-18 12:03:20	2023-04-18 12:19:09.296845	0	257
1	9876543225	10.163.19.173	W	2023-04-18 12:14:42	2023-04-21 15:50:35.501731	0	260
13	9456454541	10.163.19.176	W	2023-04-19 11:56:31	2023-04-20 11:41:19.656244	0	293
10	9879685645	10.163.19.173	W	2023-04-19 15:17:14	2023-04-21 15:56:02.824888	0	313
10	9879685645	10.163.2.160	W	2023-04-19 15:51:02	2023-04-21 15:56:02.824888	0	330
85	9487687827	10.163.19.176	W	2023-03-24 12:36:49	2023-04-22 16:04:39.962685	0	109
85	9487687827	10.163.2.160	W	2023-03-24 12:46:09	2023-04-22 16:04:39.962685	0	110
3	9876543211	10.163.19.173	W	2023-04-20 15:31:55	2023-04-21 16:15:15.541045	0	414
7	9876543210	10.163.19.176	W	2023-04-19 10:56:53	2023-05-05 11:45:51.767487	0	285
7	9876543210	10.163.19.176	W	2023-04-20 12:22:47	2023-05-05 11:45:51.767487	0	397
7	9876543210	10.163.19.173	W	2023-04-11 17:35:05	2023-05-05 11:45:51.767487	0	159
22	9897645645	10.163.2.160	W	2023-05-03 07:01:39	2023-05-08 11:02:46.827106	0	754
11	9876455645	10.163.19.173	W	2023-04-19 13:17:50	2023-04-20 12:56:24.983366	0	303
87	9080076157	10.163.2.250	W	2023-03-28 11:47:20	2023-03-28 18:29:17.326132	0	140
87	9080076157	10.163.2.250	W	2023-03-28 11:49:32	2023-03-28 18:29:17.326132	0	141
87	9080076157	10.163.19.176	W	2023-03-28 12:17:07	2023-03-28 18:29:17.326132	0	142
87	9080076157	10.163.2.96	W	2023-03-28 14:58:57	2023-03-28 18:29:17.326132	0	144
87	9080076157	10.163.2.26	W	2023-03-28 15:08:03	2023-03-28 18:29:17.326132	0	145
87	9080076157	10.163.19.176	W	2023-03-28 15:41:05	2023-03-28 18:29:17.326132	0	146
87	9080076157	10.163.19.173	W	2023-03-28 16:12:14	2023-03-28 18:29:17.326132	0	147
87	9080076157	10.163.2.26	W	2023-03-28 17:04:10	2023-03-28 18:29:17.326132	0	148
87	9080076157	10.163.19.176	W	2023-03-28 18:35:10	\N	1	149
88	9876543217	10.163.19.173	W	2023-04-17 17:59:21	2023-04-20 11:21:26.757371	0	237
88	9876543217	10.163.19.173	W	2023-04-20 11:20:19	2023-04-20 11:21:26.757371	0	378
1	9876543225	10.163.2.160	W	2023-04-19 11:48:18	2023-04-21 15:50:35.501731	0	289
90	9876543221	223.187.113.95	W	2023-04-19 22:41:17	2023-04-19 22:43:50.955999	0	355
22	9897645645	10.163.2.160	W	2023-05-02 12:24:08	2023-05-08 11:02:46.827106	0	708
85	9487687827	10.163.19.176	W	2023-03-24 12:54:31	2023-04-22 16:04:39.962685	0	111
85	9487687827	10.163.19.173	W	2023-03-24 13:00:43	2023-04-22 16:04:39.962685	0	112
85	9487687827	10.163.19.173	W	2023-03-24 13:01:26	2023-04-22 16:04:39.962685	0	113
85	9487687827	10.163.19.176	W	2023-03-24 13:21:02	2023-04-22 16:04:39.962685	0	116
85	9487687827	10.163.19.173	W	2023-03-24 14:56:49	2023-04-22 16:04:39.962685	0	118
3	9876543211	10.163.2.160	W	2023-04-20 22:34:51	2023-04-21 16:15:15.541045	0	415
3	9876543211	10.163.2.160	W	2023-04-20 13:41:44	2023-04-21 16:15:15.541045	0	410
9	9876543218	10.163.2.160	W	2023-04-19 10:55:45	2023-04-21 15:51:03.259481	0	284
85	9487687827	10.163.19.173	W	2023-03-24 14:58:41	2023-04-22 16:04:39.962685	0	119
1	9876543225	10.163.19.173	W	2023-04-17 17:52:02	2023-04-21 15:50:35.501731	0	230
1	9885632563	10.163.2.250	W	2023-03-27 16:23:21	2023-04-21 15:50:35.501731	0	134
1	9876543225	10.163.2.160	W	2023-04-19 12:12:01	2023-04-21 15:50:35.501731	0	300
9	9876543218	10.163.2.160	W	2023-04-19 12:02:00	2023-04-21 15:51:03.259481	0	297
9	9876543218	10.163.19.173	W	2023-04-18 12:17:20	2023-04-21 15:51:03.259481	0	263
3	9876543211	10.163.2.160	W	2023-04-20 14:39:04	2023-04-21 16:15:15.541045	0	411
10	9879685645	10.163.2.160	W	2023-04-20 12:38:27	2023-04-21 15:56:02.824888	0	400
3	9876543211	10.163.19.173	W	2023-04-19 15:55:14	2023-04-21 16:15:15.541045	0	335
3	9876543211	10.163.19.173	W	2023-04-19 15:56:37	2023-04-21 16:15:15.541045	0	341
3	9876543211	10.163.19.173	W	2023-04-18 12:22:48	2023-04-21 16:15:15.541045	0	266
85	9487687827	10.163.19.176	W	2023-03-24 15:51:38	2023-04-22 16:04:39.962685	0	120
3	9876543211	10.163.19.176	W	2023-04-18 10:15:22	2023-04-21 16:15:15.541045	0	245
3	9876543211	10.163.19.173	W	2023-04-17 17:50:23	2023-04-21 16:15:15.541045	0	229
22	9897645645	49.204.117.122	W	2023-04-23 01:23:14	2023-05-08 11:02:46.827106	0	472
85	9487687827	10.163.2.160	W	2023-03-24 16:24:10	2023-04-22 16:04:39.962685	0	121
1	9876543225	10.163.2.160	W	2023-04-20 12:40:54	2023-04-21 15:50:35.501731	0	404
3	9876543211	10.163.19.176	W	2023-04-17 17:54:00	2023-04-21 16:15:15.541045	0	233
1	9876543225	10.163.19.173	W	2023-04-19 15:21:32	2023-04-21 15:50:35.501731	0	317
1	9876543225	10.163.2.227	W	2023-04-20 11:15:57	2023-04-21 15:50:35.501731	0	373
1	9876543225	10.163.2.160	W	2023-04-21 10:58:33	2023-04-21 15:50:35.501731	0	418
3	9876543211	10.163.19.176	W	2023-04-17 14:54:50	2023-04-21 16:15:15.541045	0	222
22	9897645645	10.163.2.160	W	2023-04-24 10:08:35	2023-05-08 11:02:46.827106	0	490
20	9876543214	49.204.117.122	W	2023-04-23 00:27:50	2023-05-08 13:18:21.756918	0	466
20	9876543214	10.163.2.160	W	2023-04-25 10:36:59	2023-05-08 13:18:21.756918	0	531
3	9876543211	10.163.19.173	W	2023-04-21 17:29:02	\N	1	441
20	9876543214	10.163.2.160	W	2023-04-25 12:13:51	2023-05-08 13:18:21.756918	0	535
90	9876543221	223.187.113.95	W	2023-04-19 22:43:27	2023-04-19 22:43:50.955999	0	356
4	9876543212	10.163.2.160	W	2023-04-12 11:19:19	2023-04-17 16:11:29.546952	0	188
4	9876543212	10.163.19.173	W	2023-04-11 18:52:55	2023-04-17 16:11:29.546952	0	173
25	9875456454	10.163.2.160	W	2023-05-02 10:56:43	2023-05-08 13:17:38.511212	0	697
18	9876543211	10.163.2.160	W	2023-05-05 11:16:16	2023-05-08 17:12:01.580361	0	791
26	9897496465	10.163.2.160	W	2023-05-02 10:52:40	2023-05-03 11:01:52.4789	0	696
26	9897496465	10.163.2.160	W	2023-05-02 11:02:39	2023-05-03 11:01:52.4789	0	698
20	9876543214	10.163.2.160	W	2023-04-25 10:33:53	2023-05-08 13:18:21.756918	0	528
18	9876543211	10.163.2.160	W	2023-05-03 07:34:39	2023-05-08 17:12:01.580361	0	767
21	9876543125	10.163.2.26	W	2023-05-03 14:01:40	2023-05-03 17:55:06.943499	0	774
7	9876543210	10.163.19.173	W	2023-04-11 17:40:27	2023-05-05 11:45:51.767487	0	160
26	9897496465	10.163.2.160	W	2023-05-03 07:28:50	2023-05-03 11:01:52.4789	0	760
18	9876543211	10.163.2.250	W	2023-05-02 13:48:02	2023-05-08 17:12:01.580361	0	739
18	9876543211	10.163.2.160	W	2023-05-05 12:17:05	2023-05-08 17:12:01.580361	0	801
19	9876543212	10.163.2.160	W	2023-05-08 07:11:59	2023-05-08 13:43:11.849015	0	820
19	9876543212	10.163.2.160	W	2023-05-02 12:05:39	2023-05-08 13:43:11.849015	0	700
19	9876543212	10.163.2.160	W	2023-04-25 10:31:27	2023-05-08 13:43:11.849015	0	527
19	9876543212	10.163.2.160	W	2023-04-24 18:04:40	2023-05-08 13:43:11.849015	0	516
7	9876543210	10.163.2.160	W	2023-04-11 11:01:02	2023-05-05 11:45:51.767487	0	150
4	9876543212	10.163.2.160	W	2023-04-12 10:08:33	2023-04-17 16:11:29.546952	0	175
4	9876543212	10.163.2.160	W	2023-04-12 10:22:11	2023-04-17 16:11:29.546952	0	177
4	9876543212	10.163.2.160	W	2023-04-12 10:29:54	2023-04-17 16:11:29.546952	0	181
4	9876543212	10.163.2.160	W	2023-04-12 11:27:45	2023-04-17 16:11:29.546952	0	191
3	9876543211	10.163.2.160	W	2023-04-21 10:40:20	2023-04-21 16:15:15.541045	0	417
88	9876543217	10.163.19.173	W	2023-04-17 18:00:15	2023-04-20 11:21:26.757371	0	238
4	9876543212	10.163.2.160	W	2023-04-12 11:29:04	2023-04-17 16:11:29.546952	0	193
4	9876543212	10.163.19.176	W	2023-04-12 11:36:02	2023-04-17 16:11:29.546952	0	197
4	9876543212	10.163.2.160	W	2023-04-17 11:16:45	2023-04-17 16:11:29.546952	0	218
3	9876543211	10.163.2.160	W	2023-04-17 11:17:36	2023-04-21 16:15:15.541045	0	220
91	9876543222	10.163.19.173	W	2023-04-20 11:21:42	2023-04-20 11:27:47.562444	0	379
3	9876543211	10.163.2.160	W	2023-04-20 12:13:11	2023-04-21 16:15:15.541045	0	395
3	9876543211	10.163.19.173	W	2023-04-18 12:01:30	2023-04-21 16:15:15.541045	0	255
3	9876543211	10.163.19.173	W	2023-04-17 17:40:12	2023-04-21 16:15:15.541045	0	228
3	9876543211	10.163.2.160	W	2023-04-20 11:49:37	2023-04-21 16:15:15.541045	0	391
3	9876543211	10.163.2.26	W	2023-04-20 12:24:40	2023-04-21 16:15:15.541045	0	398
3	9876543211	10.163.2.160	W	2023-04-20 12:08:17	2023-04-21 16:15:15.541045	0	392
3	9876543211	10.163.19.176	W	2023-04-19 15:02:32	2023-04-21 16:15:15.541045	0	304
9	9876543218	10.163.2.160	W	2023-04-21 15:17:11	2023-04-21 15:51:03.259481	0	425
9	9876543218	10.163.2.160	W	2023-04-20 12:41:19	2023-04-21 15:51:03.259481	0	405
9	9876543218	10.163.2.160	W	2023-04-20 10:50:19	2023-04-21 15:51:03.259481	0	364
9	9876543218	10.163.2.227	W	2023-04-19 15:25:08	2023-04-21 15:51:03.259481	0	322
9	9876543218	10.163.2.160	W	2023-04-19 15:14:36	2023-04-21 15:51:03.259481	0	310
89	9876543219	10.163.19.173	W	2023-04-18 11:57:38	2023-04-18 12:19:09.296845	0	254
1	9876543225	10.163.19.173	W	2023-04-17 18:28:36	2023-04-21 15:50:35.501731	0	240
1	9876543225	10.163.19.173	W	2023-04-18 12:15:48	2023-04-21 15:50:35.501731	0	262
1	9876543225	10.163.2.160	W	2023-04-19 12:04:06	2023-04-21 15:50:35.501731	0	298
3	9876543211	10.163.19.173	W	2023-04-20 10:56:36	2023-04-21 16:15:15.541045	0	367
3	9876543211	10.163.2.160	W	2023-04-19 16:46:53	2023-04-21 16:15:15.541045	0	344
3	9876543211	10.163.19.173	W	2023-04-17 18:21:59	2023-04-21 16:15:15.541045	0	239
12	9897654545	10.163.19.176	W	2023-04-19 11:57:19	2023-04-20 11:36:43.654354	0	294
11	9876455645	10.163.2.160	W	2023-04-20 11:16:02	2023-04-20 12:56:24.983366	0	374
13	9456454541	10.163.19.173	W	2023-04-20 11:36:57	2023-04-20 11:41:19.656244	0	386
3	9876543211	10.163.19.176	W	2023-04-20 13:33:40	2023-04-21 16:15:15.541045	0	409
11	9876455645	10.163.2.26	W	2023-04-20 12:45:17	2023-04-20 12:56:24.983366	0	408
9	9876543218	10.163.19.173	W	2023-04-17 17:52:28	2023-04-21 15:51:03.259481	0	231
9	9876543218	10.163.2.160	W	2023-04-19 11:48:43	2023-04-21 15:51:03.259481	0	290
9	9876543218	10.163.19.173	W	2023-04-19 15:17:42	2023-04-21 15:51:03.259481	0	314
9	9876543218	10.163.2.160	W	2023-04-20 10:25:41	2023-04-21 15:51:03.259481	0	362
5	9876543215	10.163.2.160	W	2023-04-12 11:29:37	2023-04-17 11:17:27.382362	0	194
5	9876543215	10.163.19.173	W	2023-04-11 18:52:20	2023-04-17 11:17:27.382362	0	172
5	9876543215	10.163.2.160	W	2023-04-12 10:22:56	2023-04-17 11:17:27.382362	0	178
5	9876543215	10.163.2.160	W	2023-04-12 10:29:09	2023-04-17 11:17:27.382362	0	180
5	9876543215	10.163.2.160	W	2023-04-12 11:06:04	2023-04-17 11:17:27.382362	0	184
5	9876543215	10.163.2.160	W	2023-04-12 11:11:48	2023-04-17 11:17:27.382362	0	186
5	9876543215	10.163.19.176	W	2023-04-12 11:35:39	2023-04-17 11:17:27.382362	0	196
10	9879685645	10.163.2.160	W	2023-04-19 10:57:31	2023-04-21 15:56:02.824888	0	286
10	9879685645	10.163.19.173	W	2023-04-18 12:18:08	2023-04-21 15:56:02.824888	0	264
10	9879685645	10.163.2.160	W	2023-04-19 15:48:15	2023-04-21 15:56:02.824888	0	326
10	9879685645	10.163.2.160	W	2023-04-19 20:44:55	2023-04-21 15:56:02.824888	0	353
1	9876543225	10.163.19.173	W	2023-04-19 15:12:02	2023-04-21 15:50:35.501731	0	307
1	9876543225	10.163.2.160	W	2023-04-20 10:18:58	2023-04-21 15:50:35.501731	0	361
1	9876543225	10.163.2.160	W	2023-04-21 15:50:19	2023-04-21 15:50:35.501731	0	431
1	9876543225	10.163.19.173	W	2023-04-20 11:34:51	2023-04-21 15:50:35.501731	0	383
10	9879685645	10.163.2.160	W	2023-04-20 10:34:11	2023-04-21 15:56:02.824888	0	363
10	9879685645	10.163.2.160	W	2023-04-20 12:39:26	2023-04-21 15:56:02.824888	0	401
3	9876543211	10.163.2.160	W	2023-04-21 15:49:26	2023-04-21 16:15:15.541045	0	430
3	9876543211	10.163.19.173	W	2023-04-21 16:13:42	2023-04-21 16:15:15.541045	0	436
22	9897645645	49.204.117.122	W	2023-04-23 00:29:54	2023-05-08 11:02:46.827106	0	467
25	9875456454	10.163.19.173	W	2023-04-21 18:08:00	2023-05-08 13:17:38.511212	0	446
88	9876543217	10.163.19.173	W	2023-04-17 17:58:38	2023-04-20 11:21:26.757371	0	236
25	9875456454	10.163.2.160	W	2023-05-03 07:29:22	2023-05-08 13:17:38.511212	0	761
91	9876543222	223.187.113.95	W	2023-04-19 22:44:39	2023-04-20 11:27:47.562444	0	357
3	9876543211	10.163.19.173	W	2023-04-20 11:27:51	2023-04-21 16:15:15.541045	0	380
3	9876543211	10.163.2.160	W	2023-04-20 11:40:05	2023-04-21 16:15:15.541045	0	387
20	9876543214	10.163.2.160	W	2023-04-25 12:49:24	2023-05-08 13:18:21.756918	0	545
89	9876543219	10.163.19.173	W	2023-04-18 12:19:06	2023-04-18 12:19:09.296845	0	265
89	9876543219	10.163.19.173	W	2023-04-18 12:02:30	2023-04-18 12:19:09.296845	0	256
9	9876543218	10.163.2.160	W	2023-04-18 18:08:35	2023-04-21 15:51:03.259481	0	277
4	9876543212	10.163.19.176	W	2023-04-12 11:58:38	2023-04-17 16:11:29.546952	0	200
4	9876543212	10.163.2.26	W	2023-04-12 13:19:48	2023-04-17 16:11:29.546952	0	206
4	9876543212	49.204.130.15	W	2023-04-16 23:32:06	2023-04-17 16:11:29.546952	0	210
23	9876545156	10.163.2.160	W	2023-04-25 13:34:20	2023-05-03 17:33:26.135213	0	557
5	9876543215	49.204.130.15	W	2023-04-16 23:32:35	2023-04-17 11:17:27.382362	0	211
5	9876543215	49.204.130.15	W	2023-04-16 23:34:24	2023-04-17 11:17:27.382362	0	214
5	9876543215	10.163.2.160	W	2023-04-17 11:17:03	2023-04-17 11:17:27.382362	0	219
4	9876543212	49.204.130.15	W	2023-04-16 23:34:01	2023-04-17 16:11:29.546952	0	213
21	9876543125	49.204.142.21	W	2023-04-25 00:13:35	2023-05-03 17:55:06.943499	0	521
21	9876543125	49.204.117.122	W	2023-04-23 01:23:51	2023-05-03 17:55:06.943499	0	473
21	9876543125	10.163.2.160	W	2023-04-24 10:11:37	2023-05-03 17:55:06.943499	0	491
21	9876543125	49.204.117.122	W	2023-04-23 00:40:58	2023-05-03 17:55:06.943499	0	468
18	9876543211	10.163.2.160	W	2023-05-07 13:05:24	2023-05-08 17:12:01.580361	0	804
7	9876543210	10.163.2.250	W	2023-04-11 15:29:12	2023-05-05 11:45:51.767487	0	152
7	9876543210	10.163.19.176	W	2023-04-11 17:51:20	2023-05-05 11:45:51.767487	0	164
22	9897645645	10.163.2.160	W	2023-04-25 12:14:20	2023-05-08 11:02:46.827106	0	536
20	9876543214	10.163.2.160	W	2023-04-25 13:07:41	2023-05-08 13:18:21.756918	0	548
20	9876543214	10.163.2.160	W	2023-05-05 11:26:18	2023-05-08 13:18:21.756918	0	797
18	9876543211	10.163.2.160	W	2023-05-02 12:50:25	2023-05-08 17:12:01.580361	0	736
7	9876543210	10.163.2.160	W	2023-04-11 15:31:29	2023-05-05 11:45:51.767487	0	153
7	9876543210	10.163.19.173	W	2023-03-24 13:14:45	2023-05-05 11:45:51.767487	0	114
19	9876543212	10.163.2.160	W	2023-05-07 13:11:38	2023-05-08 13:43:11.849015	0	807
19	9876543212	10.163.2.250	W	2023-05-02 13:54:49	2023-05-08 13:43:11.849015	0	740
19	9876543212	10.163.2.160	W	2023-05-05 06:47:09	2023-05-08 13:43:11.849015	0	781
18	9876543211	10.163.2.160	W	2023-05-02 12:47:23	2023-05-08 17:12:01.580361	0	735
9	9876543218	10.163.2.227	W	2023-04-20 11:16:58	2023-04-21 15:51:03.259481	0	375
9	9876543218	10.163.2.160	W	2023-04-21 15:50:48	2023-04-21 15:51:03.259481	0	432
3	9876543211	10.163.19.173	W	2023-04-18 10:55:45	2023-04-21 16:15:15.541045	0	251
3	9876543211	10.163.19.173	W	2023-04-18 12:14:57	2023-04-21 16:15:15.541045	0	261
3	9876543211	10.163.19.173	W	2023-04-19 15:55:55	2023-04-21 16:15:15.541045	0	339
3	9876543211	10.163.19.176	W	2023-04-19 15:55:42	2023-04-21 16:15:15.541045	0	337
3	9876543211	10.163.19.173	W	2023-04-19 15:55:47	2023-04-21 16:15:15.541045	0	338
3	9876543211	10.163.19.176	W	2023-04-19 15:57:41	2023-04-21 16:15:15.541045	0	343
3	9876543211	10.163.2.160	W	2023-04-19 11:58:02	2023-04-21 16:15:15.541045	0	295
3	9876543211	10.163.19.173	W	2023-04-19 10:57:59	2023-04-21 16:15:15.541045	0	287
3	9876543211	10.163.2.160	W	2023-04-12 11:08:56	2023-04-21 16:15:15.541045	0	185
3	9876543211	10.163.19.173	W	2023-04-11 17:59:51	2023-04-21 16:15:15.541045	0	167
3	9876543211	10.163.2.160	W	2023-04-11 18:10:34	2023-04-21 16:15:15.541045	0	168
3	9876543211	10.163.2.160	W	2023-04-11 18:16:19	2023-04-21 16:15:15.541045	0	169
85	9487687827	10.163.19.176	W	2023-04-21 18:40:36	2023-04-22 16:04:39.962685	0	451
11	9876455645	10.163.19.173	W	2023-04-20 11:35:28	2023-04-20 12:56:24.983366	0	384
11	9876455645	10.163.2.160	W	2023-04-20 12:09:30	2023-04-20 12:56:24.983366	0	393
22	9897645645	49.204.117.122	W	2023-04-23 10:15:48	2023-05-08 11:02:46.827106	0	479
1	9876543225	10.163.19.173	W	2023-04-18 12:14:40	2023-04-21 15:50:35.501731	0	259
1	9876543225	10.163.2.160	W	2023-04-18 17:53:47	2023-04-21 15:50:35.501731	0	274
1	9876543225	10.163.2.160	W	2023-04-18 18:07:53	2023-04-21 15:50:35.501731	0	276
1	9876543225	10.163.19.173	W	2023-04-19 15:18:07	2023-04-21 15:50:35.501731	0	315
1	9876543225	10.163.2.160	W	2023-04-20 12:39:56	2023-04-21 15:50:35.501731	0	402
3	9876543211	10.163.2.160	W	2023-04-11 18:17:29	2023-04-21 16:15:15.541045	0	171
3	9876543211	10.163.2.160	W	2023-04-12 11:28:13	2023-04-21 16:15:15.541045	0	192
9	9876543218	10.163.19.173	W	2023-04-21 16:15:25	\N	1	437
10	9879685645	10.163.2.160	W	2023-04-20 12:41:43	2023-04-21 15:56:02.824888	0	406
10	9879685645	10.163.2.227	W	2023-04-19 15:26:06	2023-04-21 15:56:02.824888	0	323
20	9876543214	49.204.117.122	W	2023-04-23 16:40:18	2023-05-08 13:18:21.756918	0	483
25	9875456454	10.163.2.160	W	2023-05-02 12:26:33	2023-05-08 13:17:38.511212	0	710
22	9897645645	49.204.117.122	W	2023-04-23 12:36:09	2023-05-08 11:02:46.827106	0	482
22	9897645645	49.204.117.122	W	2023-04-23 01:25:42	2023-05-08 11:02:46.827106	0	475
22	9897645645	49.204.117.122	W	2023-04-23 19:01:08	2023-05-08 11:02:46.827106	0	485
19	9876543212	10.163.2.160	W	2023-05-03 07:24:18	2023-05-08 13:43:11.849015	0	756
10	9879685645	10.163.19.173	W	2023-04-17 17:53:08	2023-04-21 15:56:02.824888	0	232
20	9876543214	49.204.117.122	W	2023-04-23 18:47:46	2023-05-08 13:18:21.756918	0	484
10	9879685645	10.163.2.160	W	2023-04-18 18:22:20	2023-04-21 15:56:02.824888	0	278
10	9879685645	10.163.2.160	W	2023-04-19 11:51:26	2023-04-21 15:56:02.824888	0	291
10	9879685645	10.163.2.160	W	2023-04-19 10:06:59	2023-04-21 15:56:02.824888	0	279
10	9879685645	10.163.19.173	W	2023-04-19 15:15:09	2023-04-21 15:56:02.824888	0	311
10	9879685645	10.163.19.176	W	2023-04-19 18:05:53	2023-04-21 15:56:02.824888	0	352
10	9879685645	10.163.2.160	W	2023-04-21 15:19:40	2023-04-21 15:56:02.824888	0	426
27	9897945645	10.163.2.160	W	2023-05-03 07:29:56	2023-05-03 11:04:30.559766	0	762
19	9876543212	10.163.2.160	W	2023-04-25 13:39:27	2023-05-08 13:43:11.849015	0	562
11	9876455645	10.163.19.176	W	2023-04-19 15:02:58	2023-04-20 12:56:24.983366	0	305
11	9876455645	10.163.19.176	W	2023-04-19 11:58:41	2023-04-20 12:56:24.983366	0	296
11	9876455645	10.163.2.160	W	2023-04-20 11:11:40	2023-04-20 12:56:24.983366	0	369
3	9876543211	10.163.19.176	W	2023-04-21 15:15:57	2023-04-21 16:15:15.541045	0	424
20	9876543214	10.163.2.250	W	2023-04-24 12:08:01	2023-05-08 13:18:21.756918	0	506
3	9876543211	10.163.2.160	W	2023-04-21 15:32:04	2023-04-21 16:15:15.541045	0	429
3	9876543211	10.163.2.160	W	2023-04-19 12:12:26	2023-04-21 16:15:15.541045	0	301
3	9876543211	10.163.19.173	W	2023-04-17 18:29:00	2023-04-21 16:15:15.541045	0	241
3	9876543211	10.163.2.160	W	2023-04-19 15:13:21	2023-04-21 16:15:15.541045	0	308
3	9876543211	10.163.2.160	W	2023-04-19 15:23:02	2023-04-21 16:15:15.541045	0	319
14	7897894545	10.163.19.176	W	2023-04-19 11:56:13	2023-04-19 11:56:18.812828	0	292
3	9876543211	10.163.19.176	W	2023-04-19 15:44:50	2023-04-21 16:15:15.541045	0	324
3	9876543211	10.163.2.227	W	2023-04-19 15:21:32	2023-04-21 16:15:15.541045	0	318
85	9487687827	157.51.146.181	W	2023-04-22 15:49:30	2023-04-22 16:04:39.962685	0	455
3	9876543211	10.163.19.173	W	2023-04-19 15:53:25	2023-04-21 16:15:15.541045	0	331
23	9876545156	49.204.117.122	W	2023-04-23 01:25:03	2023-05-03 17:33:26.135213	0	474
21	9876543125	10.163.2.250	W	2023-05-02 13:58:00	2023-05-03 17:55:06.943499	0	741
20	9876543214	10.163.2.160	W	2023-04-29 13:58:01	2023-05-08 13:18:21.756918	0	662
1	9876543225	10.163.2.160	W	2023-04-20 12:10:06	2023-04-21 15:50:35.501731	0	394
1	9876543225	10.163.2.160	W	2023-04-19 15:13:59	2023-04-21 15:50:35.501731	0	309
1	9876543225	10.163.2.160	W	2023-04-19 10:55:00	2023-04-21 15:50:35.501731	0	283
1	9876543225	10.163.19.176	W	2023-04-19 15:45:28	2023-04-21 15:50:35.501731	0	325
1	9876543225	10.163.2.160	W	2023-04-19 15:49:19	2023-04-21 15:50:35.501731	0	328
18	9876543211	10.163.2.160	W	2023-04-24 10:18:32	2023-05-08 17:12:01.580361	0	495
18	9876543211	10.163.2.160	W	2023-04-25 13:36:38	2023-05-08 17:12:01.580361	0	559
18	9876543211	10.163.2.160	W	2023-05-03 14:47:14	2023-05-08 17:12:01.580361	0	779
19	9876543212	10.163.2.160	W	2023-05-07 13:06:59	2023-05-08 13:43:11.849015	0	805
19	9876543212	10.163.2.160	W	2023-04-22 19:14:38	2023-05-08 13:43:11.849015	0	461
23	9876545156	49.204.117.122	W	2023-04-23 09:25:24	2023-05-03 17:33:26.135213	0	478
23	9876545156	10.163.2.160	W	2023-04-24 10:12:08	2023-05-03 17:33:26.135213	0	492
23	9876545156	49.204.142.21	W	2023-04-25 00:15:54	2023-05-03 17:33:26.135213	0	522
23	9876545156	10.163.2.250	W	2023-04-24 12:08:37	2023-05-03 17:33:26.135213	0	507
7	9876543210	10.163.19.173	W	2023-04-21 17:43:49	2023-05-05 11:45:51.767487	0	442
7	9876543210	10.163.2.160	W	2023-04-20 15:26:08	2023-05-05 11:45:51.767487	0	412
7	9876543210	10.163.2.160	W	2023-04-20 12:15:34	2023-05-05 11:45:51.767487	0	396
7	9876543210	10.163.2.250	W	2023-03-27 16:02:00	2023-05-05 11:45:51.767487	0	132
7	9876543210	10.163.2.250	W	2023-03-27 16:22:44	2023-05-05 11:45:51.767487	0	133
7	9876543210	10.163.2.26	W	2023-03-27 16:31:04	2023-05-05 11:45:51.767487	0	135
18	9876543211	10.163.2.160	W	2023-05-03 13:28:20	2023-05-08 17:12:01.580361	0	769
19	9876543212	10.163.2.160	W	2023-04-25 11:51:02	2023-05-08 13:43:11.849015	0	532
19	9876543212	49.204.128.4	W	2023-04-29 20:41:28	2023-05-08 13:43:11.849015	0	672
22	9897645645	10.163.2.160	W	2023-04-25 11:58:43	2023-05-08 11:02:46.827106	0	534
7	9876543210	10.163.19.176	W	2023-04-12 12:01:57	2023-05-05 11:45:51.767487	0	201
22	9897645645	10.163.2.160	W	2023-04-25 13:08:05	2023-05-08 11:02:46.827106	0	549
1	9876543225	10.163.2.160	W	2023-04-21 15:10:34	2023-04-21 15:50:35.501731	0	423
9	9876543218	10.163.2.160	W	2023-04-21 15:29:59	2023-04-21 15:51:03.259481	0	427
3	9876543211	10.163.19.173	W	2023-04-18 12:30:00	2023-04-21 16:15:15.541045	0	268
3	9876543211	10.163.19.173	W	2023-04-19 15:11:34	2023-04-21 16:15:15.541045	0	306
3	9876543211	10.163.2.160	W	2023-04-18 18:07:09	2023-04-21 16:15:15.541045	0	275
10	9879685645	10.163.19.173	W	2023-04-19 15:16:26	2023-04-21 15:56:02.824888	0	312
10	9879685645	10.163.2.227	W	2023-04-20 11:17:58	2023-04-21 15:56:02.824888	0	376
10	9879685645	10.163.2.160	W	2023-04-21 15:51:14	2023-04-21 15:56:02.824888	0	433
3	9876543211	10.163.19.173	W	2023-04-18 13:20:13	2023-04-21 16:15:15.541045	0	271
3	9876543211	10.163.19.176	W	2023-04-17 10:52:19	2023-04-21 16:15:15.541045	0	216
3	9876543211	10.163.2.227	W	2023-04-17 16:11:42	2023-04-21 16:15:15.541045	0	225
3	9876543211	10.163.19.176	W	2023-04-18 10:22:33	2023-04-21 16:15:15.541045	0	246
3	9876543211	10.163.2.227	W	2023-04-17 16:10:02	2023-04-21 16:15:15.541045	0	223
3	9876543211	10.163.19.176	W	2023-04-17 17:58:14	2023-04-21 16:15:15.541045	0	235
3	9876543211	10.163.19.176	W	2023-04-18 10:44:41	2023-04-21 16:15:15.541045	0	248
3	9876543211	10.163.19.173	W	2023-04-20 10:51:54	2023-04-21 16:15:15.541045	0	365
3	9876543211	10.163.19.173	W	2023-04-19 15:19:00	2023-04-21 16:15:15.541045	0	316
3	9876543211	10.163.2.227	W	2023-04-19 15:23:45	2023-04-21 16:15:15.541045	0	320
3	9876543211	10.163.2.160	W	2023-04-19 15:48:50	2023-04-21 16:15:15.541045	0	327
3	9876543211	10.163.2.160	W	2023-04-19 15:49:45	2023-04-21 16:15:15.541045	0	329
3	9876543211	10.163.2.160	W	2023-04-20 12:43:04	2023-04-21 16:15:15.541045	0	407
3	9876543211	10.163.19.173	W	2023-04-18 11:27:10	2023-04-21 16:15:15.541045	0	252
3	9876543211	10.163.2.160	W	2023-04-12 10:07:52	2023-04-21 16:15:15.541045	0	174
3	9876543211	10.163.2.160	W	2023-04-12 10:21:28	2023-04-21 16:15:15.541045	0	176
26	9897496465	10.163.19.173	W	2023-04-21 18:12:56	2023-05-03 11:01:52.4789	0	447
27	9897945645	10.163.2.160	W	2023-05-02 12:28:49	2023-05-03 11:04:30.559766	0	711
19	9876543212	10.163.2.160	W	2023-05-05 11:02:28	2023-05-08 13:43:11.849015	0	790
19	9876543212	10.163.2.250	W	2023-04-26 11:55:26	2023-05-08 13:43:11.849015	0	613
22	9897645645	49.204.117.122	W	2023-04-23 10:17:56	2023-05-08 11:02:46.827106	0	481
91	9876543222	10.163.19.173	W	2023-04-20 10:53:16	2023-04-20 11:27:47.562444	0	366
9	9876543218	10.163.2.160	W	2023-04-20 12:40:16	2023-04-21 15:51:03.259481	0	403
19	9876543212	10.163.2.160	W	2023-05-08 09:47:46	2023-05-08 13:43:11.849015	0	849
85	9487687827	10.163.2.160	W	2023-03-24 17:13:21	2023-04-22 16:04:39.962685	0	122
85	9487687827	10.163.19.173	W	2023-03-27 11:07:16	2023-04-22 16:04:39.962685	0	124
85	9487687827	10.163.19.176	W	2023-03-27 11:07:52	2023-04-22 16:04:39.962685	0	125
85	9487687827	10.163.19.173	W	2023-03-27 11:09:13	2023-04-22 16:04:39.962685	0	126
85	9487687827	10.163.2.250	W	2023-03-27 13:12:32	2023-04-22 16:04:39.962685	0	128
85	9487687827	10.163.19.176	W	2023-03-27 15:15:50	2023-04-22 16:04:39.962685	0	129
85	9487687827	10.163.2.250	W	2023-03-27 15:43:31	2023-04-22 16:04:39.962685	0	130
85	9487687827	10.163.19.176	W	2023-03-27 18:00:00	2023-04-22 16:04:39.962685	0	136
85	9487687827	10.163.19.176	W	2023-03-28 10:31:12	2023-04-22 16:04:39.962685	0	137
85	9487687827	10.163.2.96	W	2023-03-28 11:20:18	2023-04-22 16:04:39.962685	0	138
85	9487687827	10.163.2.250	W	2023-03-28 11:40:29	2023-04-22 16:04:39.962685	0	139
85	9487687827	10.163.2.96	W	2023-03-28 12:22:46	2023-04-22 16:04:39.962685	0	143
19	9876543212	10.163.2.160	W	2023-04-26 15:09:23	2023-05-08 13:43:11.849015	0	614
23	9876545156	10.163.2.160	W	2023-04-25 13:15:30	2023-05-03 17:33:26.135213	0	552
23	9876545156	10.163.2.250	W	2023-05-02 14:00:42	2023-05-03 17:33:26.135213	0	742
21	9876543125	10.163.2.160	W	2023-04-21 19:00:16	2023-05-03 17:55:06.943499	0	453
1	9876543225	10.163.2.227	W	2023-04-20 11:18:36	2023-04-21 15:50:35.501731	0	377
1	9876543225	10.163.2.160	W	2023-04-21 15:31:14	2023-04-21 15:50:35.501731	0	428
10	9879685645	10.163.2.160	W	2023-04-21 15:55:52	2023-04-21 15:56:02.824888	0	434
3	9876543211	10.163.19.173	W	2023-04-20 11:41:27	2023-04-21 16:15:15.541045	0	388
3	9876543211	10.163.2.160	W	2023-04-19 16:49:28	2023-04-21 16:15:15.541045	0	345
3	9876543211	10.163.2.160	W	2023-04-20 11:10:06	2023-04-21 16:15:15.541045	0	368
12	9897654545	10.163.2.160	W	2023-04-20 11:12:21	2023-04-20 11:36:43.654354	0	370
12	9897654545	10.163.19.173	W	2023-04-20 11:36:03	2023-04-20 11:36:43.654354	0	385
3	9876543211	10.163.2.160	W	2023-04-19 17:46:32	2023-04-21 16:15:15.541045	0	348
3	9876543211	10.163.2.160	W	2023-04-20 12:25:00	2023-04-21 16:15:15.541045	0	399
3	9876543211	10.163.2.160	W	2023-04-20 11:13:49	2023-04-21 16:15:15.541045	0	372
3	9876543211	10.163.19.176	W	2023-04-19 15:53:48	2023-04-21 16:15:15.541045	0	333
3	9876543211	10.163.19.173	W	2023-04-18 10:30:07	2023-04-21 16:15:15.541045	0	247
3	9876543211	10.163.2.160	W	2023-04-17 10:28:49	2023-04-21 16:15:15.541045	0	215
3	9876543211	10.163.19.176	W	2023-04-17 12:42:09	2023-04-21 16:15:15.541045	0	221
3	9876543211	10.163.2.160	W	2023-04-12 10:35:57	2023-04-21 16:15:15.541045	0	183
3	9876543211	10.163.2.160	W	2023-04-12 11:14:10	2023-04-21 16:15:15.541045	0	187
3	9876543211	10.163.2.160	W	2023-04-12 11:20:13	2023-04-21 16:15:15.541045	0	189
3	9876543211	10.163.2.160	W	2023-04-17 11:01:02	2023-04-21 16:15:15.541045	0	217
3	9876543211	10.163.2.160	W	2023-04-20 11:46:58	2023-04-21 16:15:15.541045	0	390
21	9876543125	10.163.2.160	W	2023-04-24 10:06:55	2023-05-03 17:55:06.943499	0	488
21	9876543125	10.163.2.250	W	2023-04-24 12:01:53	2023-05-03 17:55:06.943499	0	502
18	9876543211	10.163.2.160	W	2023-04-26 15:30:33	2023-05-08 17:12:01.580361	0	615
7	9876543210	10.163.19.176	W	2023-04-11 17:50:31	2023-05-05 11:45:51.767487	0	163
7	9876543210	10.163.19.176	W	2023-04-11 18:17:16	2023-05-05 11:45:51.767487	0	170
7	9876543210	10.163.19.176	W	2023-04-12 11:25:42	2023-05-05 11:45:51.767487	0	190
18	9876543211	10.163.2.160	W	2023-04-26 15:42:06	2023-05-08 17:12:01.580361	0	617
18	9876543211	49.204.128.4	W	2023-04-30 01:25:07	2023-05-08 17:12:01.580361	0	690
19	9876543212	10.163.2.160	W	2023-05-08 08:55:19	2023-05-08 13:43:11.849015	0	836
7	9876543210	10.163.19.176	W	2023-04-24 10:24:12	2023-05-05 11:45:51.767487	0	497
7	9876543210	10.163.2.160	W	2023-04-25 14:48:09	2023-05-05 11:45:51.767487	0	567
7	9876543210	10.163.19.176	W	2023-04-24 16:09:16	2023-05-05 11:45:51.767487	0	514
20	9876543214	10.163.2.160	W	2023-05-08 09:15:48	2023-05-08 13:18:21.756918	0	842
7	9876543210	10.163.19.176	W	2023-04-24 17:32:00	2023-05-05 11:45:51.767487	0	515
20	9876543214	49.204.117.122	W	2023-04-23 10:16:47	2023-05-08 13:18:21.756918	0	480
20	9876543214	10.163.2.160	W	2023-04-21 18:59:49	2023-05-08 13:18:21.756918	0	452
20	9876543214	10.163.2.160	W	2023-04-24 10:16:41	2023-05-08 13:18:21.756918	0	493
20	9876543214	10.163.2.160	W	2023-04-25 10:15:41	2023-05-08 13:18:21.756918	0	525
3	9876543211	49.204.117.154	W	2023-04-20 22:55:31	2023-04-21 16:15:15.541045	0	416
3	9876543211	10.163.19.173	W	2023-04-21 11:07:10	2023-04-21 16:15:15.541045	0	419
3	9876543211	10.163.2.160	W	2023-04-21 11:16:03	2023-04-21 16:15:15.541045	0	420
3	9876543211	10.163.19.173	W	2023-04-21 13:20:02	2023-04-21 16:15:15.541045	0	421
3	9876543211	10.163.2.160	W	2023-04-21 14:36:23	2023-04-21 16:15:15.541045	0	422
3	9876543211	10.163.2.160	W	2023-04-20 15:26:37	2023-04-21 16:15:15.541045	0	413
3	9876543211	10.163.19.173	W	2023-04-18 12:11:12	2023-04-21 16:15:15.541045	0	258
3	9876543211	10.163.2.160	W	2023-04-17 21:28:07	2023-04-21 16:15:15.541045	0	242
3	9876543211	10.163.2.160	W	2023-04-19 12:04:46	2023-04-21 16:15:15.541045	0	299
3	9876543211	10.163.2.160	W	2023-04-18 10:12:40	2023-04-21 16:15:15.541045	0	243
3	9876543211	10.163.19.173	W	2023-04-19 17:43:00	2023-04-21 16:15:15.541045	0	347
3	9876543211	10.163.2.160	W	2023-04-19 17:47:16	2023-04-21 16:15:15.541045	0	349
3	9876543211	10.163.2.250	W	2023-04-19 18:01:43	2023-04-21 16:15:15.541045	0	351
3	9876543211	223.187.113.95	W	2023-04-19 22:39:07	2023-04-21 16:15:15.541045	0	354
3	9876543211	10.163.19.173	W	2023-04-17 17:37:51	2023-04-21 16:15:15.541045	0	227
3	9876543211	10.163.19.176	W	2023-04-19 15:57:16	2023-04-21 16:15:15.541045	0	342
3	9876543211	10.163.19.173	W	2023-04-20 11:33:29	2023-04-21 16:15:15.541045	0	381
3	9876543211	10.163.19.173	W	2023-04-19 13:17:29	2023-04-21 16:15:15.541045	0	302
3	9876543211	10.163.19.173	W	2023-04-20 11:34:02	2023-04-21 16:15:15.541045	0	382
3	9876543211	10.163.2.160	W	2023-04-18 10:53:53	2023-04-21 16:15:15.541045	0	250
3	9876543211	49.204.130.15	W	2023-04-16 23:30:07	2023-04-21 16:15:15.541045	0	209
3	9876543211	49.204.130.15	W	2023-04-16 23:33:16	2023-04-21 16:15:15.541045	0	212
3	9876543211	10.163.2.160	W	2023-04-18 11:37:50	2023-04-21 16:15:15.541045	0	253
3	9876543211	10.163.2.160	W	2023-04-12 10:28:12	2023-04-21 16:15:15.541045	0	179
20	9876543214	10.163.2.160	W	2023-04-25 13:10:22	2023-05-08 13:18:21.756918	0	551
92	9638527419	157.51.146.181	W	2023-04-22 16:06:46	\N	1	456
20	9876543214	10.163.2.160	W	2023-04-25 17:59:38	2023-05-08 13:18:21.756918	0	579
19	9876543212	10.163.2.160	W	2023-05-02 12:32:58	2023-05-08 13:43:11.849015	0	716
25	9875456454	10.163.2.160	W	2023-04-25 17:22:55	2023-05-08 13:17:38.511212	0	574
10	9879685645	10.163.2.26	W	2023-04-21 15:57:51	\N	1	435
3	9876543211	10.163.2.160	W	2023-04-12 10:30:22	2023-04-21 16:15:15.541045	0	182
3	9876543211	10.163.19.173	W	2023-04-19 15:53:46	2023-04-21 16:15:15.541045	0	332
3	9876543211	10.163.19.176	W	2023-04-19 15:54:02	2023-04-21 16:15:15.541045	0	334
3	9876543211	10.163.19.173	W	2023-04-19 15:55:38	2023-04-21 16:15:15.541045	0	336
3	9876543211	10.163.19.173	W	2023-04-19 15:55:59	2023-04-21 16:15:15.541045	0	340
3	9876543211	10.163.2.160	W	2023-04-20 11:42:01	2023-04-21 16:15:15.541045	0	389
3	9876543211	10.163.19.173	W	2023-04-18 10:49:51	2023-04-21 16:15:15.541045	0	249
3	9876543211	10.163.19.173	W	2023-04-18 12:22:53	2023-04-21 16:15:15.541045	0	267
3	9876543211	10.163.19.176	W	2023-04-19 17:20:08	2023-04-21 16:15:15.541045	0	346
3	9876543211	223.187.113.95	W	2023-04-19 22:47:16	2023-04-21 16:15:15.541045	0	359
3	9876543211	10.163.2.160	W	2023-04-20 09:56:10	2023-04-21 16:15:15.541045	0	360
3	9876543211	10.163.2.160	W	2023-04-19 17:48:44	2023-04-21 16:15:15.541045	0	350
3	9876543211	10.163.19.176	W	2023-04-12 11:34:56	2023-04-21 16:15:15.541045	0	195
3	9876543211	10.163.2.160	W	2023-04-19 11:47:42	2023-04-21 16:15:15.541045	0	288
3	9876543211	10.163.19.176	W	2023-04-12 11:48:12	2023-04-21 16:15:15.541045	0	198
3	9876543211	10.163.2.160	W	2023-04-12 11:49:59	2023-04-21 16:15:15.541045	0	199
3	9876543211	10.163.2.26	W	2023-04-12 13:19:13	2023-04-21 16:15:15.541045	0	205
3	9876543211	10.163.2.26	W	2023-04-12 13:26:27	2023-04-21 16:15:15.541045	0	207
3	9876543211	10.163.19.173	W	2023-04-18 13:17:34	2023-04-21 16:15:15.541045	0	269
3	9876543211	223.187.113.95	W	2023-04-19 22:45:48	2023-04-21 16:15:15.541045	0	358
3	9876543211	10.163.19.173	W	2023-04-18 13:19:27	2023-04-21 16:15:15.541045	0	270
3	9876543211	10.163.19.173	W	2023-04-18 15:59:20	2023-04-21 16:15:15.541045	0	272
3	9876543211	10.163.2.160	W	2023-04-18 17:29:29	2023-04-21 16:15:15.541045	0	273
3	9876543211	10.163.2.160	W	2023-04-19 10:47:17	2023-04-21 16:15:15.541045	0	280
3	9876543211	10.163.19.176	W	2023-04-19 10:53:49	2023-04-21 16:15:15.541045	0	282
25	9875456454	10.163.2.160	W	2023-04-25 15:58:48	2023-05-08 13:17:38.511212	0	569
21	9876543125	49.204.117.122	W	2023-04-22 23:43:54	2023-05-03 17:55:06.943499	0	465
25	9875456454	10.163.2.160	W	2023-04-25 16:12:01	2023-05-08 13:17:38.511212	0	571
25	9875456454	10.163.2.160	W	2023-05-08 09:44:08	2023-05-08 13:17:38.511212	0	846
20	9876543214	10.163.2.160	W	2023-05-08 07:13:15	2023-05-08 13:18:21.756918	0	821
19	9876543212	10.163.2.160	W	2023-05-02 14:22:47	2023-05-08 13:43:11.849015	0	745
19	9876543212	10.163.2.160	W	2023-04-21 18:27:32	2023-05-08 13:43:11.849015	0	448
19	9876543212	10.163.2.160	W	2023-05-05 11:16:34	2023-05-08 13:43:11.849015	0	792
20	9876543214	10.163.2.160	W	2023-04-25 13:30:53	2023-05-08 13:18:21.756918	0	556
20	9876543214	49.204.117.122	W	2023-04-23 01:05:25	2023-05-08 13:18:21.756918	0	471
18	9876543211	10.163.2.160	W	2023-05-08 07:10:58	2023-05-08 17:12:01.580361	0	819
22	9897645645	10.163.2.250	W	2023-05-02 14:01:52	2023-05-08 11:02:46.827106	0	743
22	9897645645	10.163.2.160	W	2023-04-25 18:01:09	2023-05-08 11:02:46.827106	0	581
19	9876543212	10.163.2.250	W	2023-04-24 11:57:01	2023-05-08 13:43:11.849015	0	501
7	9876543210	10.163.2.26	W	2023-04-12 13:11:55	2023-05-05 11:45:51.767487	0	204
18	9876543211	10.163.2.160	W	2023-05-02 14:25:48	2023-05-08 17:12:01.580361	0	746
7	9876543210	10.163.19.176	W	2023-04-13 15:52:50	2023-05-05 11:45:51.767487	0	208
7	9876543210	10.163.2.250	W	2023-04-17 16:23:50	2023-05-05 11:45:51.767487	0	226
7	9876543210	10.163.19.176	W	2023-04-19 10:53:20	2023-05-05 11:45:51.767487	0	281
7	9876543210	10.163.2.160	W	2023-04-11 16:54:57	2023-05-05 11:45:51.767487	0	154
7	9876543210	10.163.19.173	W	2023-04-11 17:01:00	2023-05-05 11:45:51.767487	0	155
18	9876543211	10.163.2.160	W	2023-05-02 14:48:25	2023-05-08 17:12:01.580361	0	750
7	9876543210	10.163.19.176	W	2023-04-11 17:08:19	2023-05-05 11:45:51.767487	0	156
18	9876543211	10.163.2.160	W	2023-05-03 06:59:18	2023-05-08 17:12:01.580361	0	751
22	9897645645	10.163.2.160	W	2023-04-25 10:16:38	2023-05-08 11:02:46.827106	0	526
22	9897645645	49.204.117.122	W	2023-04-23 01:48:12	2023-05-08 11:02:46.827106	0	477
22	9897645645	10.163.2.160	W	2023-04-25 18:24:35	2023-05-08 11:02:46.827106	0	589
19	9876543212	49.205.86.77	W	2023-04-25 22:19:26	2023-05-08 13:43:11.849015	0	596
22	9897645645	49.205.86.77	W	2023-04-25 21:47:43	2023-05-08 11:02:46.827106	0	595
22	9897645645	10.163.2.160	W	2023-05-02 12:34:25	2023-05-08 11:02:46.827106	0	718
25	9875456454	10.163.2.160	W	2023-04-25 18:06:53	2023-05-08 13:17:38.511212	0	583
7	9876543210	10.163.19.173	W	2023-04-11 17:33:10	2023-05-05 11:45:51.767487	0	157
7	9876543210	10.163.19.176	W	2023-04-11 17:45:25	2023-05-05 11:45:51.767487	0	161
22	9897645645	10.163.2.250	W	2023-04-24 12:07:13	2023-05-08 11:02:46.827106	0	505
22	9897645645	49.204.128.4	W	2023-04-29 23:52:03	2023-05-08 11:02:46.827106	0	683
22	9897645645	10.163.2.160	W	2023-04-29 11:23:38	2023-05-08 11:02:46.827106	0	656
22	9897645645	10.163.2.160	W	2023-04-28 15:20:20	2023-05-08 11:02:46.827106	0	646
22	9897645645	10.163.2.160	W	2023-04-28 18:16:10	2023-05-08 11:02:46.827106	0	650
22	9897645645	10.163.2.160	W	2023-04-29 14:40:27	2023-05-08 11:02:46.827106	0	665
19	9876543212	10.163.2.160	W	2023-05-08 07:23:49	2023-05-08 13:43:11.849015	0	826
26	9897496465	223.187.127.211	W	2023-04-25 20:24:10	2023-05-03 11:01:52.4789	0	592
26	9897496465	10.163.2.160	W	2023-04-25 18:08:24	2023-05-03 11:01:52.4789	0	584
26	9897496465	10.163.2.160	W	2023-05-02 12:29:15	2023-05-03 11:01:52.4789	0	712
26	9897496465	49.205.86.77	W	2023-04-26 07:27:41	2023-05-03 11:01:52.4789	0	608
19	9876543212	49.204.128.4	W	2023-04-29 22:42:15	2023-05-08 13:43:11.849015	0	676
19	9876543212	49.204.128.4	W	2023-04-29 23:47:37	2023-05-08 13:43:11.849015	0	681
19	9876543212	49.204.128.4	W	2023-04-30 01:10:30	2023-05-08 13:43:11.849015	0	686
27	9897945645	10.163.2.160	W	2023-04-25 18:12:46	2023-05-03 11:04:30.559766	0	586
27	9897945645	223.187.127.211	W	2023-04-25 20:23:33	2023-05-03 11:04:30.559766	0	591
27	9897945645	10.163.2.160	W	2023-05-02 12:29:57	2023-05-03 11:04:30.559766	0	713
19	9876543212	10.163.2.160	W	2023-04-24 10:17:35	2023-05-08 13:43:11.849015	0	494
22	9897645645	49.204.128.4	W	2023-04-29 20:44:37	2023-05-08 11:02:46.827106	0	674
22	9897645645	49.204.128.4	W	2023-04-30 01:13:22	2023-05-08 11:02:46.827106	0	688
25	9875456454	49.205.86.77	W	2023-04-25 23:12:45	2023-05-08 13:17:38.511212	0	604
25	9875456454	49.205.86.77	W	2023-04-26 07:24:37	2023-05-08 13:17:38.511212	0	607
25	9875456454	10.163.2.160	W	2023-05-02 12:37:20	2023-05-08 13:17:38.511212	0	720
19	9876543212	10.163.2.26	W	2023-05-03 13:43:28	2023-05-08 13:43:11.849015	0	770
19	9876543212	10.163.2.160	W	2023-05-03 14:39:05	2023-05-08 13:43:11.849015	0	778
23	9876545156	10.163.2.160	W	2023-04-29 14:41:03	2023-05-03 17:33:26.135213	0	666
23	9876545156	49.204.128.4	W	2023-04-29 22:55:50	2023-05-03 17:33:26.135213	0	677
23	9876545156	10.163.2.26	W	2023-05-03 14:02:50	2023-05-03 17:33:26.135213	0	775
21	9876543125	10.163.2.160	W	2023-04-25 18:00:21	2023-05-03 17:55:06.943499	0	580
18	9876543211	10.163.2.160	W	2023-05-02 14:09:01	2023-05-08 17:12:01.580361	0	744
19	9876543212	10.163.2.160	W	2023-04-25 17:57:41	2023-05-08 13:43:11.849015	0	578
19	9876543212	10.163.2.160	W	2023-04-25 17:22:33	2023-05-08 13:43:11.849015	0	573
19	9876543212	10.163.2.160	W	2023-04-26 17:21:07	2023-05-08 13:43:11.849015	0	623
19	9876543212	49.205.82.91	W	2023-04-26 23:30:15	2023-05-08 13:43:11.849015	0	628
19	9876543212	10.163.2.160	W	2023-04-27 15:16:03	2023-05-08 13:43:11.849015	0	632
19	9876543212	10.163.2.160	W	2023-05-08 07:16:20	2023-05-08 13:43:11.849015	0	822
19	9876543212	10.163.2.160	W	2023-04-27 18:23:00	2023-05-08 13:43:11.849015	0	633
18	9876543211	10.163.2.160	W	2023-04-28 14:35:36	2023-05-08 17:12:01.580361	0	643
21	9876543125	49.204.128.4	W	2023-04-29 22:56:19	2023-05-03 17:55:06.943499	0	678
21	9876543125	10.163.2.160	W	2023-04-29 14:45:43	2023-05-03 17:55:06.943499	0	670
21	9876543125	49.204.128.4	W	2023-04-29 23:47:06	2023-05-03 17:55:06.943499	0	680
21	9876543125	49.204.128.4	W	2023-04-29 23:50:09	2023-05-03 17:55:06.943499	0	682
18	9876543211	10.163.2.160	W	2023-04-28 18:11:52	2023-05-08 17:12:01.580361	0	647
18	9876543211	10.163.2.160	W	2023-05-02 12:30:54	2023-05-08 17:12:01.580361	0	714
18	9876543211	10.163.2.160	W	2023-04-28 18:32:14	2023-05-08 17:12:01.580361	0	651
18	9876543211	10.163.2.160	W	2023-04-29 11:04:58	2023-05-08 17:12:01.580361	0	652
18	9876543211	10.163.2.160	W	2023-04-29 11:21:50	2023-05-08 17:12:01.580361	0	654
18	9876543211	10.163.2.160	W	2023-04-29 12:48:57	2023-05-08 17:12:01.580361	0	660
18	9876543211	49.204.128.4	W	2023-04-29 20:39:39	2023-05-08 17:12:01.580361	0	671
18	9876543211	49.204.128.4	W	2023-04-30 01:09:39	2023-05-08 17:12:01.580361	0	685
20	9876543214	10.163.2.160	W	2023-05-05 08:07:47	2023-05-08 13:18:21.756918	0	787
20	9876543214	10.163.2.160	W	2023-04-25 13:16:41	2023-05-08 13:18:21.756918	0	553
20	9876543214	10.163.2.160	W	2023-04-25 17:55:00	2023-05-08 13:18:21.756918	0	576
20	9876543214	223.187.127.211	W	2023-04-25 20:24:30	2023-05-08 13:18:21.756918	0	593
20	9876543214	49.205.86.77	W	2023-04-25 23:01:35	2023-05-08 13:18:21.756918	0	599
20	9876543214	49.205.86.77	W	2023-04-25 23:07:49	2023-05-08 13:18:21.756918	0	601
20	9876543214	49.204.128.4	W	2023-04-30 01:14:36	2023-05-08 13:18:21.756918	0	689
20	9876543214	49.204.128.4	W	2023-04-30 01:09:15	2023-05-08 13:18:21.756918	0	684
20	9876543214	49.204.128.4	W	2023-04-29 20:43:09	2023-05-08 13:18:21.756918	0	673
7	9876543210	10.163.2.160	W	2023-04-26 17:26:58	2023-05-05 11:45:51.767487	0	624
20	9876543214	10.163.2.160	W	2023-04-29 14:45:09	2023-05-08 13:18:21.756918	0	669
20	9876543214	10.163.2.160	W	2023-04-28 14:59:52	2023-05-08 13:18:21.756918	0	645
20	9876543214	10.163.2.160	W	2023-04-28 18:15:21	2023-05-08 13:18:21.756918	0	649
20	9876543214	10.163.2.160	W	2023-05-07 19:07:48	2023-05-08 13:18:21.756918	0	812
26	9897496465	10.163.2.160	W	2023-05-03 07:30:14	2023-05-03 11:01:52.4789	0	763
20	9876543214	10.163.2.26	W	2023-05-03 13:46:46	2023-05-08 13:18:21.756918	0	771
20	9876543214	10.163.2.160	W	2023-05-02 12:23:44	2023-05-08 13:18:21.756918	0	707
20	9876543214	49.204.128.4	W	2023-04-30 01:12:01	2023-05-08 13:18:21.756918	0	687
20	9876543214	10.163.2.160	W	2023-05-05 06:48:03	2023-05-08 13:18:21.756918	0	782
20	9876543214	10.163.2.160	W	2023-05-05 07:22:09	2023-05-08 13:18:21.756918	0	785
19	9876543212	10.163.2.160	W	2023-04-28 11:52:14	2023-05-08 13:43:11.849015	0	640
19	9876543212	10.163.2.160	W	2023-05-08 09:16:27	2023-05-08 13:43:11.849015	0	843
19	9876543212	10.163.2.160	W	2023-05-07 13:17:23	2023-05-08 13:43:11.849015	0	809
21	9876543125	10.163.2.26	W	2023-05-03 14:03:41	2023-05-03 17:55:06.943499	0	776
25	9875456454	10.163.2.160	W	2023-05-02 10:49:06	2023-05-08 13:17:38.511212	0	695
19	9876543212	49.205.86.77	W	2023-04-25 23:00:16	2023-05-08 13:43:11.849015	0	598
19	9876543212	49.205.86.77	W	2023-04-25 23:02:43	2023-05-08 13:43:11.849015	0	600
19	9876543212	49.205.82.159	W	2023-04-27 22:29:56	2023-05-08 13:43:11.849015	0	635
19	9876543212	49.205.82.159	W	2023-04-28 00:33:08	2023-05-08 13:43:11.849015	0	636
19	9876543212	10.163.2.160	W	2023-05-02 12:56:07	2023-05-08 13:43:11.849015	0	725
7	9876543210	10.163.2.160	W	2023-05-05 08:13:06	2023-05-05 11:45:51.767487	0	788
19	9876543212	10.163.2.160	W	2023-05-02 12:18:03	2023-05-08 13:43:11.849015	0	706
19	9876543212	49.204.142.21	W	2023-04-25 00:06:54	2023-05-08 13:43:11.849015	0	520
19	9876543212	10.163.2.160	W	2023-04-24 10:05:22	2023-05-08 13:43:11.849015	0	487
19	9876543212	49.204.117.122	W	2023-04-22 23:41:34	2023-05-08 13:43:11.849015	0	463
19	9876543212	10.163.2.160	W	2023-04-25 10:34:10	2023-05-08 13:43:11.849015	0	529
18	9876543211	10.163.2.160	W	2023-05-08 09:44:44	2023-05-08 17:12:01.580361	0	847
18	9876543211	10.163.2.160	W	2023-05-02 13:37:29	2023-05-08 17:12:01.580361	0	738
18	9876543211	10.163.2.160	W	2023-05-03 07:21:53	2023-05-08 17:12:01.580361	0	755
18	9876543211	10.163.2.26	W	2023-05-03 13:26:14	2023-05-08 17:12:01.580361	0	768
18	9876543211	10.163.2.250	W	2023-05-02 14:43:56	2023-05-08 17:12:01.580361	0	729
18	9876543211	10.163.2.160	W	2023-05-02 11:10:05	2023-05-08 17:12:01.580361	0	699
18	9876543211	10.163.2.160	W	2023-04-25 10:07:12	2023-05-08 17:12:01.580361	0	523
18	9876543211	49.204.142.21	W	2023-04-24 23:25:25	2023-05-08 17:12:01.580361	0	519
18	9876543211	10.163.2.160	W	2023-04-24 10:23:16	2023-05-08 17:12:01.580361	0	496
18	9876543211	49.204.142.21	W	2023-04-24 21:57:19	2023-05-08 17:12:01.580361	0	517
18	9876543211	10.163.2.160	W	2023-05-02 12:43:29	2023-05-08 17:12:01.580361	0	722
18	9876543211	223.187.115.166	W	2023-04-25 18:14:41	2023-05-08 17:12:01.580361	0	588
18	9876543211	49.205.86.77	W	2023-04-25 22:59:19	2023-05-08 17:12:01.580361	0	597
18	9876543211	49.205.86.77	W	2023-04-25 23:09:25	2023-05-08 17:12:01.580361	0	602
19	9876543212	10.163.2.160	W	2023-05-08 09:06:03	2023-05-08 13:43:11.849015	0	839
19	9876543212	10.163.2.160	W	2023-04-25 15:59:46	2023-05-08 13:43:11.849015	0	570
19	9876543212	10.163.2.160	W	2023-04-25 12:37:05	2023-05-08 13:43:11.849015	0	539
22	9897645645	10.163.2.160	W	2023-04-25 13:35:04	2023-05-08 11:02:46.827106	0	558
22	9897645645	10.163.2.160	W	2023-05-02 12:09:03	2023-05-08 11:02:46.827106	0	702
19	9876543212	10.163.2.160	W	2023-04-25 13:27:00	2023-05-08 13:43:11.849015	0	555
19	9876543212	10.163.2.160	W	2023-04-25 12:38:26	2023-05-08 13:43:11.849015	0	540
19	9876543212	10.163.2.160	W	2023-04-25 12:48:34	2023-05-08 13:43:11.849015	0	544
22	9897645645	::1	W	2023-05-02 12:41:28	2023-05-08 11:02:46.827106	0	734
19	9876543212	10.163.2.160	W	2023-04-25 13:07:20	2023-05-08 13:43:11.849015	0	547
19	9876543212	10.163.2.160	W	2023-04-25 13:09:25	2023-05-08 13:43:11.849015	0	550
19	9876543212	10.163.2.160	W	2023-05-07 19:51:46	2023-05-08 13:43:11.849015	0	814
19	9876543212	10.163.2.160	W	2023-05-05 11:24:21	2023-05-08 13:43:11.849015	0	795
19	9876543212	10.163.2.160	W	2023-05-03 07:00:31	2023-05-08 13:43:11.849015	0	752
19	9876543212	10.163.2.160	W	2023-05-07 20:10:04	2023-05-08 13:43:11.849015	0	816
19	9876543212	10.163.2.160	W	2023-05-08 07:00:46	2023-05-08 13:43:11.849015	0	818
7	9876543210	10.163.2.250	W	2023-04-11 15:20:12	2023-05-05 11:45:51.767487	0	151
7	9876543210	10.163.19.173	W	2023-04-11 17:56:26	2023-05-05 11:45:51.767487	0	166
7	9876543210	10.163.19.176	W	2023-04-12 12:10:23	2023-05-05 11:45:51.767487	0	202
26	9897496465	10.163.2.160	W	2023-05-03 07:30:40	2023-05-03 11:01:52.4789	0	764
20	9876543214	10.163.2.160	W	2023-05-08 07:31:05	2023-05-08 13:18:21.756918	0	832
20	9876543214	10.163.2.160	W	2023-05-07 13:13:27	2023-05-08 13:18:21.756918	0	808
19	9876543212	10.163.2.160	W	2023-04-27 10:38:52	2023-05-08 13:43:11.849015	0	630
19	9876543212	10.163.2.160	W	2023-05-02 12:45:05	2023-05-08 13:43:11.849015	0	723
20	9876543214	10.163.2.160	W	2023-04-29 12:43:04	2023-05-08 13:18:21.756918	0	659
19	9876543212	10.163.2.160	W	2023-04-26 17:57:51	2023-05-08 13:43:11.849015	0	625
19	9876543212	10.163.2.160	W	2023-04-26 15:43:33	2023-05-08 13:43:11.849015	0	618
19	9876543212	10.163.2.160	W	2023-04-25 17:54:30	2023-05-08 13:43:11.849015	0	575
20	9876543214	10.163.2.160	W	2023-04-29 13:09:54	2023-05-08 13:18:21.756918	0	661
20	9876543214	10.163.2.160	W	2023-05-02 12:06:50	2023-05-08 13:18:21.756918	0	701
20	9876543214	::1	W	2023-05-02 12:40:58	2023-05-08 13:18:21.756918	0	733
20	9876543214	10.163.2.160	W	2023-05-03 07:25:18	2023-05-08 13:18:21.756918	0	757
20	9876543214	10.163.2.160	W	2023-05-05 07:21:27	2023-05-08 13:18:21.756918	0	783
18	9876543211	10.163.2.160	W	2023-05-07 20:09:18	2023-05-08 17:12:01.580361	0	815
18	9876543211	10.163.2.160	W	2023-05-02 15:03:47	2023-05-08 17:12:01.580361	0	730
18	9876543211	10.163.2.160	W	2023-04-25 13:26:22	2023-05-08 17:12:01.580361	0	554
18	9876543211	10.163.2.160	W	2023-05-02 12:24:29	2023-05-08 17:12:01.580361	0	709
20	9876543214	10.163.2.160	W	2023-05-07 18:54:20	2023-05-08 13:18:21.756918	0	810
18	9876543211	10.163.2.160	W	2023-04-25 12:39:48	2023-05-08 17:12:01.580361	0	541
22	9897645645	10.163.2.160	W	2023-05-05 11:27:15	2023-05-08 11:02:46.827106	0	798
22	9897645645	10.163.2.160	W	2023-05-07 19:46:55	2023-05-08 11:02:46.827106	0	813
18	9876543211	157.51.146.181	W	2023-04-22 15:48:57	2023-05-08 17:12:01.580361	0	454
18	9876543211	49.204.117.122	W	2023-04-22 23:40:24	2023-05-08 17:12:01.580361	0	462
18	9876543211	10.163.2.160	W	2023-04-24 10:02:28	2023-05-08 17:12:01.580361	0	486
18	9876543211	10.163.19.173	W	2023-04-24 10:30:39	2023-05-08 17:12:01.580361	0	498
18	9876543211	10.163.2.250	W	2023-04-24 11:30:18	2023-05-08 17:12:01.580361	0	499
18	9876543211	10.163.19.176	W	2023-04-24 11:46:18	2023-05-08 17:12:01.580361	0	500
18	9876543211	10.163.2.160	W	2023-04-24 14:22:17	2023-05-08 17:12:01.580361	0	510
20	9876543214	10.163.2.160	W	2023-05-08 07:17:20	2023-05-08 13:18:21.756918	0	823
18	9876543211	223.187.115.166	W	2023-04-25 18:11:54	2023-05-08 17:12:01.580361	0	585
7	9876543210	10.163.19.173	W	2023-03-24 13:18:31	2023-05-05 11:45:51.767487	0	115
7	9876543210	10.163.19.176	W	2023-04-11 17:55:36	2023-05-05 11:45:51.767487	0	165
20	9876543214	10.163.2.160	W	2023-05-08 07:28:00	2023-05-08 13:18:21.756918	0	827
20	9876543214	10.163.2.160	W	2023-05-05 11:22:17	2023-05-08 13:18:21.756918	0	793
20	9876543214	10.163.2.160	W	2023-05-05 11:35:41	2023-05-08 13:18:21.756918	0	799
20	9876543214	10.163.2.160	W	2023-05-08 07:29:27	2023-05-08 13:18:21.756918	0	829
20	9876543214	10.163.2.160	W	2023-05-08 09:05:11	2023-05-08 13:18:21.756918	0	838
7	9876543210	10.163.19.176	W	2023-03-27 12:44:49	2023-05-05 11:45:51.767487	0	127
27	9897945645	10.163.2.160	W	2023-05-03 07:32:04	2023-05-03 11:04:30.559766	0	765
19	9876543212	10.163.2.160	W	2023-05-05 13:48:42	2023-05-08 13:43:11.849015	0	802
7	9876543210	10.163.19.176	W	2023-04-11 17:47:22	2023-05-05 11:45:51.767487	0	162
7	9876543210	10.163.19.173	W	2023-04-12 12:20:38	2023-05-05 11:45:51.767487	0	203
7	9876543210	10.163.2.250	W	2023-04-24 12:52:06	2023-05-05 11:45:51.767487	0	509
7	9876543210	10.163.2.160	W	2023-04-25 14:45:14	2023-05-05 11:45:51.767487	0	564
7	9876543210	10.163.2.160	W	2023-04-25 14:46:32	2023-05-05 11:45:51.767487	0	565
7	9876543210	10.163.2.160	W	2023-05-02 13:08:10	2023-05-05 11:45:51.767487	0	737
19	9876543212	10.163.2.160	W	2023-04-25 13:37:39	2023-05-08 13:43:11.849015	0	560
19	9876543212	10.163.2.160	W	2023-05-08 09:15:12	2023-05-08 13:43:11.849015	0	841
22	9897645645	10.163.2.26	W	2023-05-03 13:55:19	2023-05-08 11:02:46.827106	0	772
22	9897645645	10.163.2.160	W	2023-05-03 07:26:50	2023-05-08 11:02:46.827106	0	758
22	9897645645	10.163.2.160	W	2023-05-08 07:18:36	2023-05-08 11:02:46.827106	0	824
22	9897645645	10.163.2.160	W	2023-05-08 07:31:40	2023-05-08 11:02:46.827106	0	833
19	9876543212	10.163.2.160	W	2023-04-26 15:38:57	2023-05-08 13:43:11.849015	0	616
19	9876543212	10.163.2.250	W	2023-04-26 16:47:08	2023-05-08 13:43:11.849015	0	621
19	9876543212	10.163.2.250	W	2023-04-26 16:48:17	2023-05-08 13:43:11.849015	0	622
19	9876543212	10.163.2.160	W	2023-04-25 12:36:26	2023-05-08 13:43:11.849015	0	538
19	9876543212	10.163.2.160	W	2023-04-21 18:28:31	2023-05-08 13:43:11.849015	0	450
19	9876543212	::1	W	2023-05-02 12:40:04	2023-05-08 13:43:11.849015	0	732
19	9876543212	10.163.2.160	W	2023-05-08 07:30:08	2023-05-08 13:43:11.849015	0	830
19	9876543212	10.163.2.160	W	2023-04-28 12:44:15	2023-05-08 13:43:11.849015	0	642
19	9876543212	10.163.2.160	W	2023-04-28 14:54:51	2023-05-08 13:43:11.849015	0	644
19	9876543212	10.163.2.160	W	2023-05-02 14:36:47	2023-05-08 13:43:11.849015	0	747
19	9876543212	10.163.2.160	W	2023-04-28 18:13:44	2023-05-08 13:43:11.849015	0	648
19	9876543212	10.163.2.160	W	2023-04-22 18:48:55	2023-05-08 13:43:11.849015	0	459
19	9876543212	49.204.117.122	W	2023-04-23 01:04:21	2023-05-08 13:43:11.849015	0	470
19	9876543212	49.205.86.77	W	2023-04-25 23:11:35	2023-05-08 13:43:11.849015	0	603
19	9876543212	10.163.2.160	W	2023-05-08 08:55:45	2023-05-08 13:43:11.849015	0	837
19	9876543212	10.163.2.160	W	2023-04-25 12:42:34	2023-05-08 13:43:11.849015	0	542
19	9876543212	10.163.2.250	W	2023-04-24 12:03:09	2023-05-08 13:43:11.849015	0	504
19	9876543212	10.163.2.160	W	2023-04-22 18:45:34	2023-05-08 13:43:11.849015	0	457
18	9876543211	49.204.128.4	W	2023-04-30 18:10:02	2023-05-08 17:12:01.580361	0	691
18	9876543211	10.163.2.160	W	2023-04-26 15:47:09	2023-05-08 17:12:01.580361	0	619
18	9876543211	10.163.2.250	W	2023-04-26 16:43:46	2023-05-08 17:12:01.580361	0	620
18	9876543211	49.205.82.91	W	2023-04-26 23:31:17	2023-05-08 17:12:01.580361	0	629
18	9876543211	49.204.128.4	W	2023-04-30 19:01:29	2023-05-08 17:12:01.580361	0	692
18	9876543211	10.163.2.160	W	2023-05-02 10:47:51	2023-05-08 17:12:01.580361	0	693
18	9876543211	10.163.2.160	W	2023-05-08 08:53:59	2023-05-08 17:12:01.580361	0	835
18	9876543211	10.163.2.160	W	2023-05-08 09:11:24	2023-05-08 17:12:01.580361	0	840
18	9876543211	10.163.2.160	W	2023-04-25 18:14:24	2023-05-08 17:12:01.580361	0	587
18	9876543211	10.163.2.160	W	2023-05-02 12:36:46	2023-05-08 17:12:01.580361	0	719
18	9876543211	10.163.2.160	W	2023-05-02 12:17:38	2023-05-08 17:12:01.580361	0	705
18	9876543211	10.163.2.160	W	2023-04-26 18:06:59	2023-05-08 17:12:01.580361	0	626
18	9876543211	49.205.82.91	W	2023-04-26 23:29:29	2023-05-08 17:12:01.580361	0	627
18	9876543211	49.205.86.77	W	2023-04-25 21:46:58	2023-05-08 17:12:01.580361	0	594
18	9876543211	10.163.2.250	W	2023-04-26 11:41:41	2023-05-08 17:12:01.580361	0	612
18	9876543211	10.163.2.160	W	2023-05-08 06:38:01	2023-05-08 17:12:01.580361	0	817
18	9876543211	10.163.2.160	W	2023-05-08 07:23:06	2023-05-08 17:12:01.580361	0	825
18	9876543211	10.163.2.160	W	2023-04-27 15:15:19	2023-05-08 17:12:01.580361	0	631
18	9876543211	10.163.2.160	W	2023-04-29 14:42:01	2023-05-08 17:12:01.580361	0	667
18	9876543211	10.163.2.160	W	2023-04-29 12:33:57	2023-05-08 17:12:01.580361	0	657
18	9876543211	49.205.82.159	W	2023-04-27 21:41:34	2023-05-08 17:12:01.580361	0	634
18	9876543211	10.163.2.160	W	2023-04-28 11:27:55	2023-05-08 17:12:01.580361	0	639
18	9876543211	10.163.2.160	W	2023-04-28 12:43:45	2023-05-08 17:12:01.580361	0	641
18	9876543211	10.163.2.160	W	2023-04-24 12:13:15	2023-05-08 17:12:01.580361	0	508
18	9876543211	49.204.117.122	W	2023-04-23 01:47:16	2023-05-08 17:12:01.580361	0	476
18	9876543211	10.163.2.160	W	2023-04-21 17:50:12	2023-05-08 17:12:01.580361	0	444
18	9876543211	10.163.2.160	W	2023-04-24 15:32:26	2023-05-08 17:12:01.580361	0	513
18	9876543211	10.163.2.160	W	2023-05-02 12:51:49	2023-05-08 17:12:01.580361	0	724
18	9876543211	10.163.2.160	W	2023-05-02 12:10:38	2023-05-08 17:12:01.580361	0	703
20	9876543214	10.163.2.160	W	2023-04-25 13:38:32	2023-05-08 13:18:21.756918	0	561
20	9876543214	10.163.2.160	W	2023-05-02 12:33:51	2023-05-08 13:18:21.756918	0	717
20	9876543214	49.204.117.122	W	2023-04-22 23:42:43	2023-05-08 13:18:21.756918	0	464
20	9876543214	10.163.2.160	W	2023-05-08 09:48:12	2023-05-08 13:18:21.756918	0	850
20	9876543214	10.163.2.160	W	2023-04-29 11:22:21	2023-05-08 13:18:21.756918	0	655
20	9876543214	10.163.2.160	W	2023-04-24 10:07:48	2023-05-08 13:18:21.756918	0	489
20	9876543214	10.163.2.250	W	2023-04-24 12:02:34	2023-05-08 13:18:21.756918	0	503
20	9876543214	10.163.2.160	W	2023-04-25 11:52:39	2023-05-08 13:18:21.756918	0	533
20	9876543214	10.163.2.160	W	2023-05-02 14:37:46	2023-05-08 13:18:21.756918	0	748
20	9876543214	10.163.2.160	W	2023-05-03 07:01:11	2023-05-08 13:18:21.756918	0	753
20	9876543214	10.163.2.26	W	2023-05-03 14:00:51	2023-05-08 13:18:21.756918	0	773
20	9876543214	10.163.2.160	W	2023-04-29 14:39:33	2023-05-08 13:18:21.756918	0	664
19	9876543212	10.163.2.160	W	2023-05-05 11:35:57	2023-05-08 13:43:11.849015	0	800
19	9876543212	10.163.2.160	W	2023-05-05 11:23:48	2023-05-08 13:43:11.849015	0	794
19	9876543212	10.163.2.160	W	2023-04-25 10:07:32	2023-05-08 13:43:11.849015	0	524
19	9876543212	49.204.117.122	W	2023-04-22 19:11:42	2023-05-08 13:43:11.849015	0	460
19	9876543212	10.163.2.160	W	2023-04-25 10:35:42	2023-05-08 13:43:11.849015	0	530
19	9876543212	10.163.2.160	W	2023-05-08 09:43:12	2023-05-08 13:43:11.849015	0	845
19	9876543212	10.163.2.160	W	2023-05-02 12:15:03	2023-05-08 13:43:11.849015	0	704
19	9876543212	49.204.128.4	W	2023-04-29 23:44:42	2023-05-08 13:43:11.849015	0	679
19	9876543212	10.163.2.160	W	2023-05-02 10:48:47	2023-05-08 13:43:11.849015	0	694
19	9876543212	10.163.2.160	W	2023-04-29 14:43:02	2023-05-08 13:43:11.849015	0	668
19	9876543212	10.163.2.160	W	2023-04-29 12:42:46	2023-05-08 13:43:11.849015	0	658
19	9876543212	10.163.2.160	W	2023-04-28 10:13:12	2023-05-08 13:43:11.849015	0	637
19	9876543212	10.163.2.160	W	2023-05-08 07:28:57	2023-05-08 13:43:11.849015	0	828
19	9876543212	49.204.142.21	W	2023-04-24 21:57:44	2023-05-08 13:43:11.849015	0	518
19	9876543212	10.163.2.160	W	2023-04-29 11:05:24	2023-05-08 13:43:11.849015	0	653
19	9876543212	10.163.2.160	W	2023-04-29 14:38:59	2023-05-08 13:43:11.849015	0	663
18	9876543211	10.163.19.176	W	2023-04-24 14:31:39	2023-05-08 17:12:01.580361	0	512
18	9876543211	10.163.2.160	W	2023-05-03 14:38:44	2023-05-08 17:12:01.580361	0	777
18	9876543211	10.163.2.160	W	2023-05-05 08:16:01	2023-05-08 17:12:01.580361	0	789
18	9876543211	10.163.2.160	W	2023-05-05 06:44:40	2023-05-08 17:12:01.580361	0	780
20	9876543214	49.204.128.4	W	2023-04-29 20:45:36	2023-05-08 13:18:21.756918	0	675
27	9897945645	10.163.2.160	W	2023-05-03 07:33:24	2023-05-03 11:04:30.559766	0	766
18	9876543211	10.163.2.160	W	2023-04-25 12:43:24	2023-05-08 17:12:01.580361	0	543
18	9876543211	10.163.2.160	W	2023-04-25 14:44:17	2023-05-08 17:12:01.580361	0	563
18	9876543211	223.187.127.211	W	2023-04-25 20:22:35	2023-05-08 17:12:01.580361	0	590
18	9876543211	10.163.2.160	W	2023-04-25 14:47:32	2023-05-08 17:12:01.580361	0	566
18	9876543211	10.163.2.160	W	2023-04-21 18:00:23	2023-05-08 17:12:01.580361	0	445
20	9876543214	10.163.2.160	W	2023-05-08 07:33:00	2023-05-08 13:18:21.756918	0	834
25	9875456454	10.163.2.160	W	2023-05-03 07:28:19	2023-05-08 13:17:38.511212	0	759
25	9875456454	10.163.2.160	W	2023-05-08 09:47:17	2023-05-08 13:17:38.511212	0	848
18	9876543211	10.163.19.173	W	2023-05-02 13:36:07	2023-05-08 17:12:01.580361	0	727
22	9897645645	10.163.2.160	W	2023-05-05 07:21:54	2023-05-08 11:02:46.827106	0	784
22	9897645645	10.163.2.160	W	2023-05-02 14:38:16	2023-05-08 11:02:46.827106	0	749
22	9897645645	10.163.2.160	W	2023-05-05 07:22:39	2023-05-08 11:02:46.827106	0	786
22	9897645645	10.163.2.160	W	2023-05-05 11:24:42	2023-05-08 11:02:46.827106	0	796
22	9897645645	10.163.2.160	W	2023-05-07 19:05:25	2023-05-08 11:02:46.827106	0	811
22	9897645645	10.163.2.160	W	2023-05-08 07:30:43	2023-05-08 11:02:46.827106	0	831
18	9876543211	10.163.2.160	W	2023-05-02 14:32:36	2023-05-08 17:12:01.580361	0	728
18	9876543211	::1	W	2023-05-02 12:14:10	2023-05-08 17:12:01.580361	0	731
18	9876543211	10.163.2.160	W	2023-05-05 15:05:07	2023-05-08 17:12:01.580361	0	803
19	9876543212	10.163.2.160	W	2023-04-28 10:39:35	2023-05-08 13:43:11.849015	0	638
19	9876543212	10.163.2.160	W	2023-05-08 10:01:18	2023-05-08 13:43:11.849015	0	852
18	9876543211	49.205.86.77	W	2023-04-25 23:18:37	2023-05-08 17:12:01.580361	0	605
18	9876543211	49.205.86.77	W	2023-04-26 07:20:47	2023-05-08 17:12:01.580361	0	606
18	9876543211	49.205.86.77	W	2023-04-26 07:29:33	2023-05-08 17:12:01.580361	0	609
18	9876543211	10.163.2.160	W	2023-04-26 10:07:48	2023-05-08 17:12:01.580361	0	610
18	9876543211	10.163.2.160	W	2023-04-26 10:52:19	2023-05-08 17:12:01.580361	0	611
18	9876543211	10.163.2.160	W	2023-04-25 14:51:24	2023-05-08 17:12:01.580361	0	568
18	9876543211	10.163.2.160	W	2023-04-25 12:54:01	2023-05-08 17:12:01.580361	0	546
18	9876543211	10.163.2.160	W	2023-05-08 09:39:33	2023-05-08 17:12:01.580361	0	844
18	9876543211	10.163.2.160	W	2023-04-25 17:56:25	2023-05-08 17:12:01.580361	0	577
18	9876543211	10.163.2.160	W	2023-04-25 16:13:04	2023-05-08 17:12:01.580361	0	572
18	9876543211	10.163.2.160	W	2023-04-25 12:15:34	2023-05-08 17:12:01.580361	0	537
18	9876543211	10.163.19.173	W	2023-04-21 17:45:20	2023-05-08 17:12:01.580361	0	443
18	9876543211	10.163.2.160	W	2023-04-21 18:27:50	2023-05-08 17:12:01.580361	0	449
18	9876543211	10.163.2.160	W	2023-04-22 18:46:35	2023-05-08 17:12:01.580361	0	458
18	9876543211	49.204.117.122	W	2023-04-23 01:03:03	2023-05-08 17:12:01.580361	0	469
18	9876543211	10.163.19.176	W	2023-04-24 14:24:10	2023-05-08 17:12:01.580361	0	511
18	9876543211	10.163.2.160	W	2023-05-07 13:09:22	2023-05-08 17:12:01.580361	0	806
18	9876543211	10.163.2.160	W	2023-04-25 18:03:17	2023-05-08 17:12:01.580361	0	582
18	9876543211	10.163.2.160	W	2023-05-02 12:32:01	2023-05-08 17:12:01.580361	0	715
18	9876543211	10.163.2.160	W	2023-05-02 12:39:43	2023-05-08 17:12:01.580361	0	721
18	9876543211	10.163.2.160	W	2023-05-02 13:03:21	2023-05-08 17:12:01.580361	0	726
18	9876543211	10.163.2.160	W	2023-05-08 09:52:27	2023-05-08 17:12:01.580361	0	851
18	9876543211	10.163.2.160	W	2023-05-08 10:13:20	2023-05-08 17:12:01.580361	0	853
\.


--
-- TOC entry 3591 (class 0 OID 45052)
-- Dependencies: 248
-- Data for Name: mst_usertype; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_usertype (usertypeid, usertypesname, usertypelname, status, createdby, createdon, updatedby, updatedon, usertypecode) FROM stdin;
1	C	Citizen	Y	\N	\N	\N	\N	01
2	D	Department	Y	\N	\N	\N	\N	02
\.


--
-- TOC entry 3593 (class 0 OID 45056)
-- Dependencies: 250
-- Data for Name: mst_zone; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.mst_zone (zoneid, zonecode, zonesname, zonelname, statecode, statusflag, createdby, createdon, updatedby, updatedon) FROM stdin;
1	06	MDU-E	Madurai(East)	\N	Y	1	2023-04-17 12:46:59.098417	1	2023-04-17 12:46:59.098417
2	07	MDU-W	Madurai(West)	\N	Y	1	2023-04-17 12:46:59.098417	1	2023-04-17 12:46:59.098417
3	08	Coimbatore	Coimbatore	\N	Y	1	2023-04-17 12:46:59.098417	1	2023-04-17 12:46:59.098417
4	09	CBE Z-I	Coimbatore Zone - I	\N	Y	1	2023-04-17 12:46:59.098417	1	2023-04-17 12:46:59.098417
5	10	CBE Z-II	Coimbatore Zone - II	\N	Y	1	2023-04-17 12:46:59.098417	1	2023-04-17 12:46:59.098417
6	11	CBE Z-III	Coimbatore Zone - III	\N	Y	1	2023-04-17 12:46:59.098417	1	2023-04-17 12:46:59.098417
7	12	POY	Pollachi	\N	Y	1	2023-04-17 12:46:59.098417	1	2023-04-17 12:46:59.098417
8	01	CH	Chennai	\N	Y	1	2023-04-17 12:46:59.098417	1	2023-04-17 12:46:59.098417
9	02	Z-I	Zone-I	\N	Y	1	2023-04-17 12:46:59.098417	1	2023-04-17 12:46:59.098417
10	03	Z-II	Zone-II	\N	Y	1	2023-04-17 12:46:59.098417	1	2023-04-17 12:46:59.098417
11	04	Z-III	Zone-III	\N	Y	1	2023-04-17 12:46:59.098417	1	2023-04-17 12:46:59.098417
12	05	Z-IV	Zone-IV	\N	Y	1	2023-04-17 12:46:59.098417	1	2023-04-17 12:46:59.098417
\.


--
-- TOC entry 3595 (class 0 OID 45062)
-- Dependencies: 252
-- Data for Name: test; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.test (id, fname) FROM stdin;
1	Paul
2	Paulw
\.


--
-- TOC entry 3597 (class 0 OID 45068)
-- Dependencies: 254
-- Data for Name: transaction_detail; Type: TABLE DATA; Schema: mybillmyright; Owner: postgres
--

COPY mybillmyright.transaction_detail (trans_id, transno, bill_user_id, process_code, alloted_by, alloted_on, forwarded_to, remarks, updated_by, updated_on, forwardedto_role_action_code, updatedby_role_action_code, bill_selection_id) FROM stdin;
\.


--
-- TOC entry 3599 (class 0 OID 45074)
-- Dependencies: 256
-- Data for Name: test; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.test (id, name) FROM stdin;
\.


--
-- TOC entry 3631 (class 0 OID 0)
-- Dependencies: 211
-- Name: bill_selection_details_bill_selection_id_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.bill_selection_details_bill_selection_id_seq', 822, true);


--
-- TOC entry 3632 (class 0 OID 0)
-- Dependencies: 213
-- Name: bill_selection_history_bill_selection_history_id_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.bill_selection_history_bill_selection_history_id_seq', 4, true);


--
-- TOC entry 3633 (class 0 OID 0)
-- Dependencies: 215
-- Name: billdetail_billdetailid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.billdetail_billdetailid_seq', 239, true);


--
-- TOC entry 3634 (class 0 OID 0)
-- Dependencies: 258
-- Name: history_transactions_transhistory_id_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.history_transactions_transhistory_id_seq', 1, false);


--
-- TOC entry 3635 (class 0 OID 0)
-- Dependencies: 217
-- Name: mst_charge_chargeid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_charge_chargeid_seq', 27, true);


--
-- TOC entry 3636 (class 0 OID 0)
-- Dependencies: 219
-- Name: mst_circle_circleid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_circle_circleid_seq', 35, true);


--
-- TOC entry 3637 (class 0 OID 0)
-- Dependencies: 220
-- Name: mst_config_configid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_config_configid_seq', 7, true);


--
-- TOC entry 3638 (class 0 OID 0)
-- Dependencies: 224
-- Name: mst_dept_user_userid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_dept_user_userid_seq', 28, true);


--
-- TOC entry 3639 (class 0 OID 0)
-- Dependencies: 227
-- Name: mst_division_divisionid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_division_divisionid_seq', 4, true);


--
-- TOC entry 3640 (class 0 OID 0)
-- Dependencies: 231
-- Name: mst_menu_mapping_menuid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_menu_mapping_menuid_seq', 1, true);


--
-- TOC entry 3641 (class 0 OID 0)
-- Dependencies: 228
-- Name: mst_menu_menuid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_menu_menuid_seq', 29, true);


--
-- TOC entry 3642 (class 0 OID 0)
-- Dependencies: 233
-- Name: mst_role_roleid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_role_roleid_seq', 1, true);


--
-- TOC entry 3643 (class 0 OID 0)
-- Dependencies: 235
-- Name: mst_roleaction_roleactionid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_roleaction_roleactionid_seq', 7, true);


--
-- TOC entry 3644 (class 0 OID 0)
-- Dependencies: 237
-- Name: mst_roletype_roletypeid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_roletype_roletypeid_seq', 7, true);


--
-- TOC entry 3645 (class 0 OID 0)
-- Dependencies: 242
-- Name: mst_user_charge_userchargeid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_user_charge_userchargeid_seq', 28, true);


--
-- TOC entry 3646 (class 0 OID 0)
-- Dependencies: 243
-- Name: mst_user_userid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_user_userid_seq', 93, true);


--
-- TOC entry 3647 (class 0 OID 0)
-- Dependencies: 245
-- Name: mst_userlog_userlogid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_userlog_userlogid_seq', 11, true);


--
-- TOC entry 3648 (class 0 OID 0)
-- Dependencies: 247
-- Name: mst_userlogindetail_userloginid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_userlogindetail_userloginid_seq', 853, true);


--
-- TOC entry 3649 (class 0 OID 0)
-- Dependencies: 249
-- Name: mst_usertype_usertypeid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_usertype_usertypeid_seq', 1, false);


--
-- TOC entry 3650 (class 0 OID 0)
-- Dependencies: 251
-- Name: mst_zone_zoneid_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.mst_zone_zoneid_seq', 7, true);


--
-- TOC entry 3651 (class 0 OID 0)
-- Dependencies: 253
-- Name: test_id_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.test_id_seq', 2, true);


--
-- TOC entry 3652 (class 0 OID 0)
-- Dependencies: 255
-- Name: transaction_detail_trans_id_seq; Type: SEQUENCE SET; Schema: mybillmyright; Owner: postgres
--

SELECT pg_catalog.setval('mybillmyright.transaction_detail_trans_id_seq', 332, true);


--
-- TOC entry 3653 (class 0 OID 0)
-- Dependencies: 257
-- Name: test_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.test_id_seq', 1, false);


--
-- TOC entry 3359 (class 2606 OID 45100)
-- Name: billdetail billdetail_pk; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.billdetail
    ADD CONSTRAINT billdetail_pk PRIMARY KEY (billdetailid);


--
-- TOC entry 3357 (class 2606 OID 45102)
-- Name: bill_selection_history billselectionhistorypkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.bill_selection_history
    ADD CONSTRAINT billselectionhistorypkey PRIMARY KEY (billdetailid, userid, distcode, seed_value);


--
-- TOC entry 3355 (class 2606 OID 45104)
-- Name: bill_selection_details billselectionpkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.bill_selection_details
    ADD CONSTRAINT billselectionpkey PRIMARY KEY (billdetailid, userid, distcode, seed_value);


--
-- TOC entry 3401 (class 2606 OID 45479)
-- Name: history_transactions htpkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.history_transactions
    ADD CONSTRAINT htpkey PRIMARY KEY (transhistory_id);


--
-- TOC entry 3361 (class 2606 OID 45108)
-- Name: mst_charge mst_charge_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_charge
    ADD CONSTRAINT mst_charge_pkey PRIMARY KEY (chargeid);


--
-- TOC entry 3363 (class 2606 OID 45110)
-- Name: mst_circle mst_circle_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_circle
    ADD CONSTRAINT mst_circle_pkey PRIMARY KEY (circleid);


--
-- TOC entry 3365 (class 2606 OID 45112)
-- Name: mst_config mst_config_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_config
    ADD CONSTRAINT mst_config_pkey PRIMARY KEY (configcode);


--
-- TOC entry 3367 (class 2606 OID 45114)
-- Name: mst_configlog mst_configlog_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_configlog
    ADD CONSTRAINT mst_configlog_pkey PRIMARY KEY (configlogid);


--
-- TOC entry 3369 (class 2606 OID 45116)
-- Name: mst_dept_user mst_dept_user_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_dept_user
    ADD CONSTRAINT mst_dept_user_pkey PRIMARY KEY (userid);


--
-- TOC entry 3371 (class 2606 OID 45118)
-- Name: mst_district mst_district_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_district
    ADD CONSTRAINT mst_district_pkey PRIMARY KEY (distcode);


--
-- TOC entry 3373 (class 2606 OID 45120)
-- Name: mst_division mst_division_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_division
    ADD CONSTRAINT mst_division_pkey PRIMARY KEY (divisioncode);


--
-- TOC entry 3377 (class 2606 OID 45122)
-- Name: mst_menu_mapping mst_menu_mapping_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_menu_mapping
    ADD CONSTRAINT mst_menu_mapping_pkey PRIMARY KEY (menuid);


--
-- TOC entry 3375 (class 2606 OID 45124)
-- Name: mst_menu mst_menu_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_menu
    ADD CONSTRAINT mst_menu_pkey PRIMARY KEY (menuid);


--
-- TOC entry 3379 (class 2606 OID 45126)
-- Name: mst_role mst_role_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_role
    ADD CONSTRAINT mst_role_pkey PRIMARY KEY (roleid);


--
-- TOC entry 3381 (class 2606 OID 45128)
-- Name: mst_roleaction mst_roleaction_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_roleaction
    ADD CONSTRAINT mst_roleaction_pkey PRIMARY KEY (roleactioncode);


--
-- TOC entry 3383 (class 2606 OID 45130)
-- Name: mst_roletype mst_roletype_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_roletype
    ADD CONSTRAINT mst_roletype_pkey PRIMARY KEY (roletypecode);


--
-- TOC entry 3385 (class 2606 OID 45132)
-- Name: mst_scheme mst_scheme_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_scheme
    ADD CONSTRAINT mst_scheme_pkey PRIMARY KEY (schemecode);


--
-- TOC entry 3387 (class 2606 OID 45134)
-- Name: mst_state mst_state_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_state
    ADD CONSTRAINT mst_state_pkey PRIMARY KEY (statecode);


--
-- TOC entry 3391 (class 2606 OID 45136)
-- Name: mst_user_charge mst_user_charge_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_user_charge
    ADD CONSTRAINT mst_user_charge_pkey PRIMARY KEY (userchargeid);


--
-- TOC entry 3389 (class 2606 OID 45138)
-- Name: mst_user mst_user_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_user
    ADD CONSTRAINT mst_user_pkey PRIMARY KEY (mobilenumber);


--
-- TOC entry 3393 (class 2606 OID 45140)
-- Name: mst_usertype mst_usertype_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_usertype
    ADD CONSTRAINT mst_usertype_pkey PRIMARY KEY (usertypecode);


--
-- TOC entry 3395 (class 2606 OID 45142)
-- Name: mst_zone mst_zone_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_zone
    ADD CONSTRAINT mst_zone_pkey PRIMARY KEY (zonecode);


--
-- TOC entry 3397 (class 2606 OID 45144)
-- Name: transaction_detail transaction_detail_pkey; Type: CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.transaction_detail
    ADD CONSTRAINT transaction_detail_pkey PRIMARY KEY (trans_id);


--
-- TOC entry 3399 (class 2606 OID 45146)
-- Name: test test_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.test
    ADD CONSTRAINT test_pkey PRIMARY KEY (id);


--
-- TOC entry 3402 (class 2606 OID 45147)
-- Name: billdetail billdetail_configcode_fkey; Type: FK CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.billdetail
    ADD CONSTRAINT billdetail_configcode_fkey FOREIGN KEY (configcode) REFERENCES mybillmyright.mst_config(configcode);


--
-- TOC entry 3403 (class 2606 OID 45152)
-- Name: billdetail billdetail_distcode_fkey; Type: FK CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.billdetail
    ADD CONSTRAINT billdetail_distcode_fkey FOREIGN KEY (distcode) REFERENCES mybillmyright.mst_district(distcode);


--
-- TOC entry 3404 (class 2606 OID 45157)
-- Name: billdetail billdetail_statecode_fkey; Type: FK CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.billdetail
    ADD CONSTRAINT billdetail_statecode_fkey FOREIGN KEY (statecode) REFERENCES mybillmyright.mst_state(statecode);


--
-- TOC entry 3405 (class 2606 OID 45162)
-- Name: mst_configlog mst_configlog_configcode_fkey; Type: FK CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_configlog
    ADD CONSTRAINT mst_configlog_configcode_fkey FOREIGN KEY (configcode) REFERENCES mybillmyright.mst_config(configcode) NOT VALID;


--
-- TOC entry 3406 (class 2606 OID 45167)
-- Name: mst_configlog mst_configlog_schemecode_fkey; Type: FK CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_configlog
    ADD CONSTRAINT mst_configlog_schemecode_fkey FOREIGN KEY (schemecode) REFERENCES mybillmyright.mst_scheme(schemecode) NOT VALID;


--
-- TOC entry 3408 (class 2606 OID 45172)
-- Name: mst_user mst_user_distcode_fkey; Type: FK CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_user
    ADD CONSTRAINT mst_user_distcode_fkey FOREIGN KEY (distcode) REFERENCES mybillmyright.mst_district(distcode);


--
-- TOC entry 3409 (class 2606 OID 45177)
-- Name: mst_user mst_user_schemecode_fkey; Type: FK CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_user
    ADD CONSTRAINT mst_user_schemecode_fkey FOREIGN KEY (schemecode) REFERENCES mybillmyright.mst_scheme(schemecode);


--
-- TOC entry 3410 (class 2606 OID 45182)
-- Name: mst_user mst_user_statecode_fkey; Type: FK CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_user
    ADD CONSTRAINT mst_user_statecode_fkey FOREIGN KEY (statecode) REFERENCES mybillmyright.mst_state(statecode);


--
-- TOC entry 3407 (class 2606 OID 45187)
-- Name: mst_dept_user mst_user_statecode_fkey; Type: FK CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_dept_user
    ADD CONSTRAINT mst_user_statecode_fkey FOREIGN KEY (statecode) REFERENCES mybillmyright.mst_state(statecode);


--
-- TOC entry 3411 (class 2606 OID 45192)
-- Name: mst_userlog mst_userlog_distcode_fkey; Type: FK CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_userlog
    ADD CONSTRAINT mst_userlog_distcode_fkey FOREIGN KEY (distcode) REFERENCES mybillmyright.mst_district(distcode);


--
-- TOC entry 3412 (class 2606 OID 45197)
-- Name: mst_userlog mst_userlog_schemecode_fkey; Type: FK CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_userlog
    ADD CONSTRAINT mst_userlog_schemecode_fkey FOREIGN KEY (schemecode) REFERENCES mybillmyright.mst_scheme(schemecode);


--
-- TOC entry 3413 (class 2606 OID 45202)
-- Name: mst_userlog mst_userlog_statecode_fkey; Type: FK CONSTRAINT; Schema: mybillmyright; Owner: postgres
--

ALTER TABLE ONLY mybillmyright.mst_userlog
    ADD CONSTRAINT mst_userlog_statecode_fkey FOREIGN KEY (statecode) REFERENCES mybillmyright.mst_state(statecode);


--
-- TOC entry 3614 (class 0 OID 0)
-- Dependencies: 220
-- Name: SEQUENCE mst_config_configid_seq; Type: ACL; Schema: mybillmyright; Owner: postgres
--

REVOKE ALL ON SEQUENCE mybillmyright.mst_config_configid_seq FROM postgres;
GRANT ALL ON SEQUENCE mybillmyright.mst_config_configid_seq TO postgres WITH GRANT OPTION;


--
-- TOC entry 3617 (class 0 OID 0)
-- Dependencies: 228
-- Name: SEQUENCE mst_menu_menuid_seq; Type: ACL; Schema: mybillmyright; Owner: postgres
--

REVOKE ALL ON SEQUENCE mybillmyright.mst_menu_menuid_seq FROM postgres;
GRANT ALL ON SEQUENCE mybillmyright.mst_menu_menuid_seq TO postgres WITH GRANT OPTION;


-- Completed on 2023-05-08 17:23:05

--
-- PostgreSQL database dump complete
--

