<?php namespace WpConvertloop\ContactForm;

class Form{

    static function instance() 
    {
        static $obj;

        if (!isset($obj)) {
            $obj = new self;
        }

        return $obj;
    }

    private function __construct() 
    {

    }

    public function start()
    {
        add_action('wpcf7_before_send_mail',array($this, 'wpcf7_register_person'));
    }

    /**
     * Funcion que registra una persona en Convertloop pero debe existir 
     * el campo 'your-email' y 'your-name' definidos en el formulario.
     * 
     * TODO: buscar una forma que funcione independientemente del nombre de los campos
     */
    public function wpcf7_register_person($wpcf7)
    {
        $submission = \WPCF7_Submission::get_instance();

        if ( $submission ) {
            $posted_data = $submission->get_posted_data();
        }

        $convertloop = \WpConvertloop\Convertloop\Convertloop::instance();

        $person = array(
            "email" => $posted_data['your-email'],
            "first_name" => $posted_data['your-name']
        );
        $convertloop->people()->createOrUpdate($person);

        return $wpcf7;
    }
}