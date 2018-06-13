<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); // This Prevents browsers from directly accessing this PHP file.
/* 
|--------------------------------------------------------------------------
| LICENSE
|--------------------------------------------------------------------------
|     
| This program is free software: you can redistribute it and/or modify
| it under the terms of the GNU General Public License as published by
| the Free Software Foundation, either version 3 of the License, or
| (at your option) any later version.
|
| This program is distributed in the hope that it will be useful,
| but WITHOUT ANY WARRANTY; without even the implied warranty of
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
| GNU General Public License for more details.
|
|  You should have received a copy of the GNU General Public License
| along with this program.  If not, see <http://www.gnu.org/licenses/>.
|-----------------------------------------------------------------------------
| INFORMATIONAL
|-----------------------------------------------------------------------------
| ldap_auth - user authentication using AD/ldap suitable for site wide passwords
| Author: Dwayne Hale
| Library Requirements: CodeIgniter >= v2.0.3
|                       ldap_auth_config.php config file.
| Methods:
|    *  authenticate - authenticate user name and pass word
|    *  info - ldap information about a user
| 
| Usage:
|    load the library by calling:
|       $this->load->library('ldap_auth');
|    somewhere in your controller of your CodeIgniter app before trying to call these functions:
|       $this->ldap_auth->auth($user, $pass);
|    OR
|       $this->ldap_auth->info($user);
*/
class LDAP_auth{
            //takes username and password, returns:
            //true if user could bind to ldap server
            //false if not.
	   public function auth($username, $password)
           {
                $CI =& get_instance();
                $CI->config->load('ldap_auth');
                $ldaprdn = $CI->config->item('ds');
                $dc = $CI->config->item('dc');
                $user_prefix = $CI->config->item('user_prefix');
                ldap_set_option($ldaprdn, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldaprdn, LDAP_OPT_REFERRALS, 0);

                $bind = @ldap_bind($ldaprdn, $user_prefix.$username, $password);
                
                if ($bind) {
                    //echo "logueado";
                    //return TRUE;
                    $filter="(sAMAccountName=$username)";
                    $result = ldap_search($ldaprdn,$dc,$filter);
                    //echo "result:".$result;
                    @ldap_sort($ldaprdn,$result,"389");
                    $info = ldap_get_entries($ldaprdn, $result);
                    $user_login = array();
                    for ($i=0; $i<$info["count"]; $i++)
                    {
                        //echo "info0:".$info[$i]["sn"][0];
                        
                        if($info['count'] > 1){
                            echo "break";
                            break;
                        }
                        //echo "<p>Correo: ".$info[$i]["userprincipalname"][0]."</p>"; //mail
                       // echo "<p>Name: ".$info[$i]["givenname"][0]." ".$info[$i]["sn"][0]."</p>";//Nombre Completo
                        $userDn = $info[$i]["distinguishedname"][0]; 
                        //echo "<p>Grupos: ".$userDn."</p>";    
                        
                        $user_login['user_email'] =  $info[$i]["userprincipalname"][0];
                        $user_login['user_name'] = $info[$i]["givenname"][0]." ".$info[$i]["sn"][0];
                        //echo $userDn;
                        if (strpos(strtolower($userDn), 'wifiadmin')) {
                            $user_login['roll_name'] = 'wifiadmin' ;
                        }
                        else if ($user_login['user_email'] == "reinierir@cug.co.cu") {
                             $user_login['roll_name'] = 'wifiadmin' ;
                        }
                        else if (strpos(strtolower($userDn), 'profesores') !== FALSE) {
                            $user_login['roll_name'] = 'profesores' ;
                        }
                        else if (strpos(strtolower($userDn), 'estudiantes')) {
                            $user_login['roll_name'] = 'estudiantes' ;
                        }
                        else 
                            $user_login['roll_name'] = 'no_docentes' ;
                        return $user_login;
                        
                    }
                    @ldap_close($ldap);
                } else {
                    return False;
                }   
			// // No need to check if they are populated, CodeIgniter has a built-in validation class for this.
			// /* try to bind to the ldap server using the following
			// * username and password, if we can't bind then the user
			// * typed the wrong username or the wrong password.
			// */
            //     //get CodeIgniter stuffs.
            //     $CI =& get_instance();
            //     $CI->config->load('ldap_auth');
                
            //     $ds = $CI->config->item('ds');
            //     ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            //     ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
            //     $server = $CI->config->item('ldap_server'); //using domain, If the DC is down DNS will route to another DC.
            //     //$user_prefix = $CI->config->item('user_prefix'); //checking for domain. e.g. YOUDOMAIN\YOUNAME
            //     //$user_suffix = $CI->config->item('user_suffix');
            //     $dc = $CI->config->item('dc');
            //             // Have to turn off errors or ldap_bind issues stack trace
            //             //echo $username;
            //             //echo $password;
            //     $bind = ldap_bind($ds,$username, $password);
              
            //     //if we can bind we can grind.
            //     if ($bind){
            //         return TRUE;
            //     }
            //     else{
            //         return FALSE;
            //     }

	    }//END authenticate

		  // search ldap for given user
		  // if found return entries (as array), else return null
	    public function info($username) {
                    //get CodeIgniter stuffs.
                $CI =& get_instance();
                $CI->config->load('ldap_auth');

	        $ds = $CI->config->item('ds');
	        $server = $CI->config->item('ldap_server'); //using domain, If the DC is down DNS will route to another DC.
	        //$user_prefix = $CI->config->item('user_prefix'); //checking for domain.
	       // $user_suffix = $CI->config->item('user_suffix');
	        $dc = $CI->config->item('dc');
            $filter = "(sAMAccountName=$username)";
            $attr = array("displayname");
			$search = ldap_search($ds, 
                                  $dc,
				                  $filter,
                                  $attr);
			$info = null;
			if ($search){
			  $info = ldap_get_entries($ds, $search);
			}
            echo $info;
			return $info;
		}//END info
   }//END ldap_auth.php