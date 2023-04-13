<?php
/*
Plugin Name: Contact Form Plugin
Version: 1.0
Description: A custom contact form plugin for WordPress.
Author: fati fati
*/
add_action('admin_menu', 'register_contact_form_menu');
function register_contact_form_menu() {
    add_menu_page('Contact Form Plugin', 'Contact Form', 'manage_options', 'contact-form',);
}
// Create the "wp_contact_form" table in the database when activating the plugin
register_activation_hook(__FILE__, 'create_contact_form_table');
function create_contact_form_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'plugin_de_formulaire';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        sujet varchar(255) NOT NULL,
        nom varchar(255) NOT NULL,
        prenom varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        message text NOT NULL,
        date_envoi datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

// Delete the "wp_contact_form" table from the database when deactivating the plugin:
    register_deactivation_hook(__FILE__, 'delete_contact_form_table');
function delete_contact_form_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'plugin_de_formulaire';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
}
// create a shortcode that will display the form
add_shortcode('contact_form', 'contact_form_shortcode');
function contact_form_shortcode() {
    // Code pour afficher le formulaire
    $output = '<form method="post" action="" id="contact">';
    $output .= '<h3>Contact Us</h3>';

    $output .= '<div>';
    $output .= '<label for="sujet">Sujet :</label>';
    $output .= '<input type="text" name="sujet" required>';
    $output .= '</div>';
    $output .= '<div>';
    $output .= '<label for="nom">Nom :</label>';
    $output .= '<input type="text" name="nom" required>';
    $output .= '</div>';
    $output .= '<div>';
    $output .= '<label for="prenom">Prénom :</label>';
    $output .= '<input type="text" name="prenom" required>';
    $output .= '</div>';
    $output .= '<div>';
    $output .= '<label for="email">Email :</label>';
    $output .= '<input type="email" name="email" required>';
    $output .= '</div>';
    $output .= '<div>';
    $output .= '<label for="message">Message :</label>';
    $output .= '<textarea name="message" required></textarea>';
    $output .= '</div>';
    $output .= '<div>';
    $output .= '<input type="submit" name="submit" value="Envoyer">';
    $output .= '</div>';
    $output .= '</form>';

    return $output;

};
if ( isset( $_POST['submit'] ) ) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'contact_form';
    
    $sujet = sanitize_text_field( $_POST['sujet'] );
    $nom = sanitize_text_field( $_POST['nom'] );
    $prenom = sanitize_text_field( $_POST['prenom'] );
    $email = sanitize_email( $_POST['email'] );
    $message = sanitize_textarea_field( $_POST['message'] );
    $date_envoi = current_time( 'mysql' );
    $wpdb->insert( 
        $table_name, 
        array( 
            'sujet' => $sujet, 
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'message' => $message,
            'date_envoi' => $date_envoi,
        ) 
    );
$output .= '<div class="notice notice-success is-dismissible">';
$output .= '<p>' . __( 'Thank you!', 'contact-form' ) . '</p>';
$output .= '</div>';
};
// add css

// add menu admin page

function enqueue_contact_form_styles() {
    wp_enqueue_style( 'contact-form-styles', plugins_url( 'contact-form.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'enqueue_contact_form_styles' );

add_action( 'admin_menu', 'contact_form_menu' );
function contact_form_menu() {
add_menu_page(
__( 'Contact Form Submissions', 'contact-form' ),
__( 'Contact Form', 'contact-form' ),
'manage_options',
'contact-form-submissions',
'contact_form_submissions_page',
'dashicons-email'
);
}
//Display the submissions page
function contact_form_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_form';
    $submissions = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY date_envoi DESC" );
    echo '<div class="wrap">';
    echo '<h1>' . __( 'Contact Form', 'contact-form' ) . '</h1>';
    if ( $submissions ) {
        echo '<table class="widefat">';
        echo '<thead><tr><th>' . __( 'Sujet', 'contact-form' ) . '</th><th>' . __( 'Nom', 'contact-form' ) . '</th><th>' . __( 'Prenom', 'contact-form' ) . '</th><th>' . __( 'Email', 'contact-form' ) . '</th><th>' . __( 'Message', 'contact-form' ) . '</th><th>' . __( 'Date Sent', 'contact-form' ) . '</th><th></th></tr></thead>';
        echo '<tbody>';
        foreach ( $submissions as $submission ) {
            echo '<tr>';
            echo '<td>' . esc_html( $submission->sujet ) . '</td>';
            echo '<td>' . esc_html( $submission->nom ) . '</td>';
            echo '<td>'.  esc_html( $submission->prenom ) .' </td>';
            echo '<td>' . esc_html( $submission->email ) . '</td>';
            echo '<td>' . esc_html( $submission->message ) . '</td>';
            echo '<td>' . date_i18n( get_option( 'date_format' ), strtotime( $submission->date_envoi ) ) . '</td>';
            echo '<td><form method="post" action=""><input type="hidden" name="submission_id" value="' . $submission->id . '"><input type="submit" class="button" name="delete_submission" value="' . __('Delete', 'contact-form') . '"></form></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>' . __( 'No submissions yet.', 'contact-form' ) . '</p>';
    }
    echo '</div>';
    
    // Handle submission deletion
    if ( isset( $_POST['delete_submission'] ) && isset( $_POST['submission_id'] ) ) {
        $submission_id = intval( $_POST['submission_id'] );
        $wpdb->delete( $table_name, array( 'id' => $submission_id ) );
        echo '<div class="notice notice-success"><p>' . __( 'Submission deleted.', 'contact-form' ) . '</p></div>';
    }
}

?>