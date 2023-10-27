<?php
    class View {
        public function __construct() {

        }

        function render($nombre) {
            require 'views/'.$nombre.'.php';
        }
    }
?>