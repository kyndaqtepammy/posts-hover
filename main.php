<?php
namespace REDO;
if (!defined('ABSPATH')) exit;
class E_REDO {
   public function __construct() {
      add_action('init', [$this, 'check_for_install']);
      add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
   }

   private function include_widgets_files() {
      require_once(__DIR__ . '/widgets/postshover.php');
   }
   
   public function register_widgets() {
      $this->include_widgets_files();
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Postshover());
   }
   public function check_for_install() {
      E_REDO::show_redo_warning();
      return;
   }
   private function show_redo_warning() {
      if (!defined('ELEMENTOR_VERSION')) {
         $link = "https://pl.wordpress.org/plugins/elementor/";
         $plugin = "Elementor Page Builder";
?>
         <div class="notice notice-warning is-dismissible">
            <p>Please install <a href="<?php echo $link; ?>"><?php echo $plugin; ?></a> to use Elementor Posts Hover Widget.</p>
         </div>
      <?php
      }
   }
}
