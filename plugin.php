<?php
    /**
     * Plugin Name: WP Admin Notes Plugin
     * Version: 0.0.1
     * Author: Mutamba Abudi
     * Author URI: www.mutambaabudi.com
     * Description: A simple Wordpress Notes plugin
     */

     //Add a new menu item to WordPress Admin Dashboard.

     function admin_notes_menu(){
        add_menu_page('Admin Notes', 'Admin Notes', 'manage_options', 'admin-notes-wpanp', 'admin_notes_page', 'dashicons-book', 10);
     }

     function admin_notes_page(){ ?>
         <div class="wrap">
        <?php if( !current_user_can('manage_options')){ ?>
            ?>
               <p>
                  Access denied. You are admin previlidges.
               </p>
            <?php
            return;  
         }
            $notes = get_option('admin_notes');
            if(!is_array($notes)){
               $notes = array();
            }

            if(isset($_POST['submit_admin_notes_wpanp'])) {
               // $notes = $_POST['admin_note_wpanp']; its not safe

               $note = sanitize_textarea_field( $_POST['admin_note_wpanp']);
               $notes[] = $note;

               $result = update_option('admin_notes', $notes);

               if($result) {
                  ?>
                  <p class="updated notice is-dismissible">
                     Note saved successfully
                  </p>
                  <?php
               } else {
                  ?>
                  <p class = 'notice notice-error'>
                     Sorry, Note not saved.
                  </p>
                  <?php
               }
            }

         ?>
         <div>
            <h3>
               Add a new note
            </h3>
            <form method="post">
               <div>
                  <textarea name="admin_note_wpanp" placeholder="Enter a note."></textarea>  
                  <button type="submit" name="submit_admin_notes_wpanp">Save Note</button>  

       </div>

            </form>
         </div>
         <?php if(count($notes)) { ?>
               <h3> Your notes!(<?= count($notes); ?>)</h3>
               <table>
                  <tbody>
                     <?php for($i = count($notes) - 1; $i >= 0; $i--): ?>
                        <tr>
                           <td><?= $notes[$i]; ?></td>
                        </tr>
                     <?php endfor; ?>
                  </tbody>
               </table>
         <?php } else { ?>
                  <p>
                     Notes not found, Add some notes.
                  </p>
               <?php
            } ?>
       </div>

     <?php } 

     // This hook will attach the admin notes function to wordpess
     add_action('admin_menu', 'admin_notes_menu');
     