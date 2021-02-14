<?php
namespace REDO\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit;
class Postshover extends Widget_Base {
    public function __construct( $data = [], $args = null) {
        parent::__construct($data, $args) ;
            wp_register_style('phcss', plugins_url( '/assets/css/postshover.css' , __FILE__ ));
            wp_register_script('phjs', plugins_url( '/assets/js/postshover.js' , __FILE__ ));
            wp_localize_script('phjs', 'ajax_obj', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax-nonce')
            ));
    }

    public function get_script_depends() {
        return ['phjs'];
    }

    public function get_style_depends() {
        return ['phcss'];
    }


   public function get_name() {
      return 'postshover';
   }
   public function get_title() {
      return __( 'Posts Hover' );
   }
   public function get_icon() {
      return 'fa fa-mouse-pointer';
   }
   public function get_categories(){
      return ['basic'];
   }
   public function list_all_cats() {
      $categories = get_categories();
      $cat_array = [];
      foreach ($categories as $category) :
          $cat_array[$category->term_id] = $category->name ;
      endforeach;
      return $cat_array;
  }
   protected function _register_controls() {
      $this->start_controls_section(
         'section_ph-content',
         [
           'label' => 'Settings',
         ]
       );
       $this->add_control(
         'postshover',
         [
           'label' => 'Posts Category',
           'type' => \Elementor\Controls_Manager::HEADING,
           'default' => 'Posts Category'
         ]
       );

       $this->add_control(
			'category',
			array(
				'label'   => __( 'Category' ),
				'type'    => Controls_Manager::SELECT,
            'default' => __( 'Category' ),
            'description' => "Select the category of posts to be displayed with this widget",
            'default' => 'Select a category',
            'options' => $this->list_all_cats(),
			)
    );

      $this->add_control(
        'wordcountheading',
        [
          'label' => 'Title Word Count',
          'type' => \Elementor\Controls_Manager::HEADING,
          'default' => 'Title Word Count'
        ]
      );

       $this->add_control(
			'wordcount',
			array(
				'label'   => __( 'Wordcount' ),
				'type'    => Controls_Manager::NUMBER,
            'default' => __( 'Wordcount' ),
            'description' => "Number of words to display in the title",
            'min' => -1,
            'max'=>255,
            'step'=>1,
            'default' => "55",
			)
    );

    $this->add_control(
        'postsperpage',
        array(
            'label'   => __( 'Posts per page' ),
            'type'    => Controls_Manager::NUMBER,
        'default' => __( 'Posts' ),
        'description' => "Number of posts to display on the page",
        'min' => -1,
        'max'=>50,
        'step'=>1,
        'default' => "-1",
        )
);

      
       $this->end_controls_section();
     }
     protected function render(){
      $settings = $this->get_settings_for_display();
      $args = array(
         'post_type' => 'post',
         'posts_per_page' => $settings['postsperpage'],
         'orderby' => 'date',
         'cat' =>  $settings['category']
     );
     $postshover = new \WP_Query($args);
?>
         <!-- HTML DESIGN HERE -->
     <div class="row">
             <?php while ($postshover->have_posts()) :  $postshover->the_post();      
             //$img_url = the_post_thumbnail_url();
 ?>
             <div class="ph-container col-md-6 col-sm-6 col-xs-12">
            <div class="ph-content" style="background-image: url(<?php the_post_thumbnail_url(); ?>)">
                <!--<a href="<?php //echo get_permalink(); ?>"> -->
                    <div class="ph-content-overlay"></div>
                    <img class="ph-content-image" src="<?php the_post_thumbnail_url(); ?>"/>
                    <div class="ph-content-details fadeIn-bottom">
                        <h3><?php echo wp_trim_words( get_the_title(), (int)$settings['wordcount'], ' <span class="ph-readmore"> Read More...</span>') ?></h3>
                        <p class="ph-content-text"><?php  ?></p>
                    </div>
               <!-- </a>-->
            </div>
        </div>
             <?php endwhile; ?>
     </div>
         <!-- HTML END DESIGN HERE -->
       <?php
     }
      function example_ajax_request() {
        $nonce = $_REQUEST['nonce'];
        print_r($_REQUEST['nonce']);
        // if( !wp_verify_nonce( $nonce, 'phjs')) {
        //     die('Nonce could not be verified');
        // }
    
        // if( isset($_REQUEST) ) {
        //     $fruit = $_REQUEST['fruit'];
        //     echo $fruit;
        // }
        wp_die();
    }
    
   }
add_action('wp_ajax_example_ajax_request', ['Postshover', 'example_ajax_request' ]);
add_action('wp_ajax_nopriv_example_ajax_request',['Postshover', 'example_ajax_request']);
