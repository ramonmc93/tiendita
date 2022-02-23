<?
    namespace App\Library;

    class FuncionesGenerales
    {
        
        public $funcionesGenerales = null;

        function __construct() {
            $this->funcionesGenerales = true;
        }

        // --- Función para mostrar el contenido ordenado en el layout del navegador.
        public static function pre( $array = array() ) {
            echo "<pre>";
                var_dump($array);
            echo "</pre>";
        }

        // --- Función para mostrar el array en formato json.
        public static function console( array $array = array() ) {
            print_r(json_encode($array));
        }

        public static function email($email) {

            if ( preg_match('/^\w+([\.-]?\w+)+@\w+([\.-]?\w+)+(\.[a-zA-Z0-9]{2,3})+$/', $email) === 1 ) {
                return true;
            }
        
            return false;
            
        }

        // --- Decodificar resultados de consulta devueltos.
        public static function parsQuery($stmt){
            return json_decode(json_encode($stmt), 1);
        }
        
    }
    
?>