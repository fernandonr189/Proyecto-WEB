<?php
    class Main extends Controller {

        public function __construct() {
            parent::__construct();

            $this->view->mensaje2 = "Hello";
        }

        function render() {
            $this->view->render('main');
        }
    }
?>