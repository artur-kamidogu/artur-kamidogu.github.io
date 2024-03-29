<?php
if (! function_exists('band_digital_setup')){
    function band_digital_setup(){
        // Пользовательский логотип
        add_theme_support('custom-logo', [
            'height'      => 50,
            'width'       => 130,
            'flex-width'  => false,
            'flex-height' => false,
            'header-text' => '',
            'unlink-homepage-logo' => false, // WP 5.5
        ] );
//подключаем поддержку  html5 тэгов 
add_theme_support( 'html5', array(
	'comment-list',
	'comment-form',
	'search-form',
	'gallery',
	'caption',
	'script',
	'style',
) );
        // Динамический title
        add_theme_support('title-tag');
    }
    add_action('after_setup_theme', 'band_digital_setup'); 
}
//добавляем миниатюры к постам 
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 730, 480,true); //размер миниатюры поста по умолчанию 
// подключение стилей и скриптов  
// правильный способ подключить стили и скрипты
add_action( 'wp_enqueue_scripts', 'band_digital_scripts' );

function band_digital_scripts() { 
	wp_enqueue_style( 'main', get_stylesheet_uri() );

    // bootstrap
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() .'/plugins/bootstrap/css/bootstrap.css',array('main'),null );

    //fontawesome
    wp_enqueue_style( 'fontawesome', get_template_directory_uri() .'/plugins/fontawesome/css/all.css',array('main'),null );

     // animate 
	wp_enqueue_style( 'animate', get_template_directory_uri() .'/plugins/animate-css/animate.css',array('main'),null ); 

    //  Icofont Css 
	wp_enqueue_style( 'icofont', get_template_directory_uri() .'/plugins/icofont/icofont.css',array('main'),null ); 

    //style css
    wp_enqueue_style( 'band-digital', get_template_directory_uri() .'/css/style.css',array('icofont'),null ); 

    //переподключаем jquery

    wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery',  get_template_directory_uri() .'/plugins/jquery/jquery.min.js');
	wp_enqueue_script( 'jquery' );

    wp_enqueue_script( 'popper', get_template_directory_uri() . '/plugins/bootstrap/js/popper.min.js', array('jquery'), '1.0.0', true );

    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/plugins/bootstrap/js/bootstrap.min.js', array('popper'), '1.0.0', true );

    wp_enqueue_script( 'wow', get_template_directory_uri() . '/plugins/counterup/wow.min.js', array('popper'), '1.0.0', true );
	
    wp_enqueue_script( 'easing', get_template_directory_uri() . '/plugins/counterup/jquery.easing.1.3.js', array('popper'), '1.0.0', true );

    wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/plugins/counterup/jquery.waypoints.js', array('popper'), '1.0.0', true );

    wp_enqueue_script( 'counterup', get_template_directory_uri() . '/plugins/counterup/jquery.counterup.min.js', array('popper'), '1.0.0', true );

    wp_enqueue_script( 'google-map', get_template_directory_uri() . '/plugins/google-map/gmap3.min.js', array('popper'), '1.0.0', true );

    wp_enqueue_script( 'contact', get_template_directory_uri() . '/plugins/form/contact.js', array('popper'), '1.0.0', true );
    
    wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array('popper'), '1.0.0', true );
}
/**
 * Регистрируем несколько областей меню 
 */
function band_digital_menus() {
//   Собираем несколько зон меню 
	$locations = array(
		'header'  => __( 'Header Menu', 'band_digital' ),
		'footer_left'   => __( 'Footer Left Menu', 'band_digital' ),
		'footer_right'   => __( 'Footer Right Menu', 'band_digital' ),

	);
// регистрируем области меню которые лежат в переменной $locations 
	register_nav_menus( $locations );
}
add_action('init','band_digital_menus');

class bootstrap_4_walker_nav_menu extends Walker_Nav_menu {
    
    function start_lvl( &$output, $depth = 0, $args = array() ){ // ul
        $indent = str_repeat("\t",$depth); // indents the outputted HTML
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
    }
  
  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){ // li a span
        
    $indent = ( $depth ) ? str_repeat("\t",$depth) : '';
    
    $li_attributes = '';
        $class_names = $value = '';
    
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        
        $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
        $classes[] = ($item->current || $item->current_item_anchestor) ? 'active' : '';
        $classes[] = 'nav-item';
        $classes[] = 'nav-item-' . $item->ID;
        if( $depth && $args->walker->has_children ){
            $classes[] = 'dropdown-menu';
        }
        
        $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr($class_names) . '"';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
        
        $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';
        
        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        $attributes .= ( $args->walker->has_children ) ? ' class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="nav-link"';
        
        $item_output = $args->before;
        $item_output .= ( $depth > 0 ) ? '<a class="dropdown-item"' . $attributes . '>' : '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    
    }
    
}
## отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );

function delete_intermediate_image_sizes( $sizes ){

	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}

// удаляет H2 из шаблона пагинации
add_filter('navigation_markup_template', 'my_navigation_template', 10, 2 );
function my_navigation_template( $template, $class ){
	/*
	Вид базового шаблона:
	<nav class="navigation %1$s" role="navigation">
		<h2 class="screen-reader-text">%2$s</h2>
		<div class="nav-links">%3$s</div>
	</nav>
	*/

	return '
	<nav class="navigation %1$s" role="navigation">
		<div class="nav-links">%3$s</div>
	</nav>
	';
}

// выводим пагинацию
the_posts_pagination( array(
	'end_size' => 2,
) );

add_action('widgets_init', 'band_digital_widgets_init');

function band_digital_widgets_init(){
    register_sidebar(array(
        'name'          => esc_html__('Сайдбар блога', 'band_digital'),
        'id'            => "sidebar-blog",
        'before_widget' => '<section id="%1$s" class="sidebar-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5 class="widget-title mb-3">',
        'after_title'   => '</h5>'

    ));
	register_sidebar(array(
        'name'          => esc_html__('Текст в подвале', 'band_digital'),
        'id'            => "sidebar-footer-text",
        'before_widget' => '<div  class="footer-widget footer-link %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>'
    ));
	register_sidebar(array(
        'name'          => esc_html__('Контакты в подвале', 'band_digital'),
        'id'            => "sidebar-footer-contacts",
        'before_widget' => '<div  class="footer-widget footer-text %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>'
    ));
}


/**
 * Добавление нового виджета Download_Widget.
 */
class Download_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'download_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: download_widget
			'Полезные файлы',
			array( 'description' => 'Прикрепите ссылки на полезные файлы', 'classname' => 'download', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_download_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_download_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$file_name =  $instance['file_name'] ;
		$file =  $instance['file'] ;


		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo '<a href="'.$file.'"><i class="fa fa-file-pdf"></i>'.$file_name.'</a>';
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Полезные файлы';
		$file = @ $instance['file'] ?: 'URL файла ';
		$file_name = @ $instance['file_name'] ?: 'Название файла';

        


		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

        <p>
			<label for="<?php echo $this->get_field_id( 'file_name' ); ?>"><?php _e( 'Название файла:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'file_name' ); ?>" name="<?php echo $this->get_field_name( 'file_name' ); ?>" type="text" value="<?php echo esc_attr( $file_name ); ?>">
		</p>

        <p>
			<label for="<?php echo $this->get_field_id( 'file' ); ?>"><?php _e( 'Ссылка на файл:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'file' ); ?>" name="<?php echo $this->get_field_name( 'file' ); ?>" type="text" value="<?php echo esc_attr( $file ); ?>">
		</p>
		<?php
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['file_name'] = ( ! empty( $new_instance['file'] ) ) ? strip_tags( $new_instance['file_name'] ) : '';
		$instance['file'] = ( ! empty( $new_instance['file'] ) ) ? strip_tags( $new_instance['file'] ) : '';


		return $instance;
	}

	// скрипт виджета
	function add_download_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_download_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_template_directory_uri();

		// wp_enqueue_script('download_widget_script', $theme_url .'/download_widget_script.js' );
	}

	// стили виджета
	function add_download_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_download_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.download_widget a{ display:inline; }
		</style>
		<?php
	}

}
// регистрация Download_Widget в WordPress
function register_download_widget() {
	register_widget( 'Download_Widget' );
}
add_action( 'widgets_init', 'register_download_widget' );

// готовим  шаблон для коментариев 
?>

<?php
class Bootstrap_Walker_Comment extends Walker {

	/**
	 * What the class handles.
	 *
	 * @since 2.7.0
	 * @var string
	 *
	 * @see Walker::$tree_type
	 */
	public $tree_type = 'comment';

	/**
	 * Database fields to use.
	 *
	 * @since 2.7.0
	 * @var string[]
	 *
	 * @see Walker::$db_fields
	 * @todo Decouple this
	 */
	public $db_fields = array(
		'parent' => 'comment_parent',
		'id'     => 'comment_ID',
	);

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::start_lvl()
	 * @global int $comment_depth
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int    $depth  Optional. Depth of the current comment. Default 0.
	 * @param array  $args   Optional. Uses 'style' argument for type of HTML list. Default empty array.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= '<ol class="children">' . "\n";
				break;
			case 'ul':
			default:
				$output .= '<ul class="children">' . "\n";
				break;
		}
	}

	/**
	 * Ends the list of items after the elements are added.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::end_lvl()
	 * @global int $comment_depth
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int    $depth  Optional. Depth of the current comment. Default 0.
	 * @param array  $args   Optional. Will only append content if style argument value is 'ol' or 'ul'.
	 *                       Default empty array.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= "</ol><!-- .children -->\n";
				break;
			case 'ul':
			default:
				$output .= "</ul><!-- .children -->\n";
				break;
		}
	}

	/**
	 * Traverses elements to create list from elements.
	 *
	 * This function is designed to enhance Walker::display_element() to
	 * display children of higher nesting levels than selected inline on
	 * the highest depth level displayed. This prevents them being orphaned
	 * at the end of the comment list.
	 *
	 * Example: max_depth = 2, with 5 levels of nested content.
	 *     1
	 *      1.1
	 *        1.1.1
	 *        1.1.1.1
	 *        1.1.1.1.1
	 *        1.1.2
	 *        1.1.2.1
	 *     2
	 *      2.2
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::display_element()
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $element           Comment data object.
	 * @param array      $children_elements List of elements to continue traversing. Passed by reference.
	 * @param int        $max_depth         Max depth to traverse.
	 * @param int        $depth             Depth of the current element.
	 * @param array      $args              An array of arguments.
	 * @param string     $output            Used to append additional content. Passed by reference.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element ) {
			return;
		}

		$id_field = $this->db_fields['id'];
		$id       = $element->$id_field;

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

		/*
		 * If at the max depth, and the current element still has children, loop over those
		 * and display them at this level. This is to prevent them being orphaned to the end
		 * of the list.
		 */
		if ( $max_depth <= $depth + 1 && isset( $children_elements[ $id ] ) ) {
			foreach ( $children_elements[ $id ] as $child ) {
				$this->display_element( $child, $children_elements, $max_depth, $depth, $args, $output );
			}

			unset( $children_elements[ $id ] );
		}
	}

	/**
	 * Starts the element output.
	 *
	 * @since 2.7.0
	 * @since 5.9.0 Renamed `$comment` to `$data_object` and `$id` to `$current_object_id`
	 *              to match parent class for PHP 8 named parameter support.
	 *
	 * @see Walker::start_el()
	 * @see wp_list_comments()
	 * @global int        $comment_depth
	 * @global WP_Comment $comment       Global comment object.
	 *
	 * @param string     $output            Used to append additional content. Passed by reference.
	 * @param WP_Comment $data_object       Comment data object.
	 * @param int        $depth             Optional. Depth of the current comment in reference to parents. Default 0.
	 * @param array      $args              Optional. An array of arguments. Default empty array.
	 * @param int        $current_object_id Optional. ID of the current comment. Default 0.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) {
		// Restores the more descriptive, specific name for use within this method.
		$comment = $data_object;

		++$depth;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment']       = $comment;

		if ( ! empty( $args['callback'] ) ) {
			ob_start();
			call_user_func( $args['callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}

		if ( 'comment' === $comment->comment_type ) {
			add_filter( 'comment_text', array( $this, 'filter_comment_text' ), 40, 2 );
		}

		if ( ( 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ) && $args['short_ping'] ) {
			ob_start();
			$this->ping( $comment, $depth, $args );
			$output .= ob_get_clean();
		} elseif ( 'html5' === $args['format'] ) {
			ob_start();
			$this->html5_comment( $comment, $depth, $args );
			$output .= ob_get_clean();
		} else {
			ob_start();
			$this->comment( $comment, $depth, $args );
			$output .= ob_get_clean();
		}

		if ( 'comment' === $comment->comment_type ) {
			remove_filter( 'comment_text', array( $this, 'filter_comment_text' ), 40 );
		}
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 2.7.0
	 * @since 5.9.0 Renamed `$comment` to `$data_object` to match parent class for PHP 8 named parameter support.
	 *
	 * @see Walker::end_el()
	 * @see wp_list_comments()
	 *
	 * @param string     $output      Used to append additional content. Passed by reference.
	 * @param WP_Comment $data_object Comment data object.
	 * @param int        $depth       Optional. Depth of the current comment. Default 0.
	 * @param array      $args        Optional. An array of arguments. Default empty array.
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = array() ) {
		if ( ! empty( $args['end-callback'] ) ) {
			ob_start();
			call_user_func(
				$args['end-callback'],
				$data_object, // The current comment object.
				$args,
				$depth
			);
			$output .= ob_get_clean();
			return;
		}
		if ( 'div' === $args['style'] ) {
			$output .= "</div><!-- #comment-## -->\n";
		} else {
			$output .= "</li><!-- #comment-## -->\n";
		}
	}

	/**
	 * Outputs a pingback comment.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment The comment object.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function ping( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
			<div class="comment-body">
				<?php _e( 'Pingback:' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
		<?php
	}

	/**
	 * Filters the comment text.
	 *
	 * Removes links from the pending comment's text if the commenter did not consent
	 * to the comment cookies.
	 *
	 * @since 5.4.2
	 *
	 * @param string          $comment_text Text of the current comment.
	 * @param WP_Comment|null $comment      The comment object. Null if not found.
	 * @return string Filtered text of the current comment.
	 */
	public function filter_comment_text( $comment_text, $comment ) {
		$commenter          = wp_get_current_commenter();
		$show_pending_links = ! empty( $commenter['comment_author'] );

		if ( $comment && '0' == $comment->comment_approved && ! $show_pending_links ) {
			$comment_text = wp_kses( $comment_text, array() );
		}

		return $comment_text;
	}

	/**
	 * Outputs a single comment.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function comment( $comment, $depth, $args ) {
		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}

		$commenter          = wp_get_current_commenter();
		$show_pending_links = isset( $commenter['comment_author'] ) && $commenter['comment_author'];

		if ( $commenter['comment_author_email'] ) {
			$moderation_note = __( 'Your comment is awaiting moderation.' );
		} else {
			$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.' );
		}
		?>
		<<?php echo $tag; ?> <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' !== $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php
			if ( 0 != $args['avatar_size'] ) {
				echo get_avatar( $comment, $args['avatar_size'] );
			}
			?>
			<?php
			$comment_author = get_comment_author_link( $comment );

			if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
				$comment_author = get_comment_author( $comment );
			}

			printf(
				/* translators: %s: Comment author link. */
				__( '%s <span class="says">says:</span>' ),
				sprintf( '<cite class="fn">%s</cite>', $comment_author )
			);
			?>
		</div>
		<?php if ( '0' == $comment->comment_approved ) : ?>
		<em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
		<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata">
			<?php
			printf(
				'<a href="%s">%s</a>',
				esc_url( get_comment_link( $comment, $args ) ),
				sprintf(
					/* translators: 1: Comment date, 2: Comment time. */
					__( '%1$s at %2$s' ),
					get_comment_date( '', $comment ),
					get_comment_time()
				)
			);

			edit_comment_link( __( '(Edit)' ), ' &nbsp;&nbsp;', '' );
			?>
		</div>

		<?php
		comment_text(
			$comment,
			array_merge(
				$args,
				array(
					'add_below' => $add_below,
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
				)
			)
		);
		?>

		<?php
		comment_reply_link(
			array_merge(
				$args,
				array(
					'add_below' => $add_below,
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>',
				)
			)
		);
		?>

		<?php if ( 'div' !== $args['style'] ) : ?>
		</div>
		<?php endif; ?>
		<?php
	}

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

		$commenter          = wp_get_current_commenter();
		$show_pending_links = ! empty( $commenter['comment_author'] );

		if ( $commenter['comment_author_email'] ) {
			$moderation_note = __( 'Ваш коментарий ждет модерации.' );
		} else {
			$moderation_note = __( 'Ваш коментарий ждет модерации. Это превью. Ваш коментарий будет опубликован после проверки.' );
		}
		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="media mb-4">
				<?php
				if ( 0 != $args['avatar_size'] ) {
					echo get_avatar( $comment, $args['avatar_size'], 'mystery', '' , array ('class'=> 'img-fluid d-flex mr-4 rounded'));
				}
				?>
				<footer >
						<?php
						$comment_author = get_comment_author_link( $comment );

						if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
							$comment_author = get_comment_author( $comment );
						}

						printf(
							/* translators: %s: Comment author link. */
							__( '%s ' ),
							sprintf( '<h5 >%s</h5>', $comment_author )
						);
						?>
					

					<div class="comment-metadata">
						<?php
						printf(
							'<a href="%s" class="text-muted"><time datetime="%s">%s</time></a>',
							esc_url( get_comment_link( $comment, $args ) ),
							get_comment_time( 'c' ),
							sprintf(
								/* translators: 1: Comment date, 2: Comment time. */
								__( '%1$s at %2$s' ),
								get_comment_date( 'j F Y', $comment ),
								get_comment_time('')
							)
						);

						edit_comment_link( __( 'Edit' ), ' <span class="edit-link">', '</span>' );
						?>
					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
					<?php endif; ?>
					
					<div class="mt-2">
						<?php comment_text(); ?>
					</div><!-- .mt-2 -->

					<?php
					if ( '1' == $comment->comment_approved || $show_pending_links ) {
						comment_reply_link(
							array_merge(
								$args,
								array(
									'add_below' => 'div-comment',
									'depth'     => $depth,
									'max_depth' => $args['max_depth'],
									'before'    => '<div class="reply">',
									'after'     => '</div>',
								)
							)
						);
					}
					?>
				</footer><!-- .comment-meta -->


			</article><!-- .comment-body -->
		<?php
	}
}

//регистрируем новый тип записи услуги
add_action('init', 'my_custom_init_service');
function my_custom_init_service(){
	register_post_type('service', array(
		'labels'             => array(
			'name'               => __('Услуги'), // Основное название типа записи
			'singular_name'      => __('Услуга'), // отдельное название записи типа service
			'add_new'            => __('Добавить новую'),
			'add_new_item'       => __('Добавить новую услугу'),
			'edit_item'          => __('Редактировать услугу'),
			'new_item'           => __('Новая услуга'),
			'view_item'          => __('Посмотреть услугу'),
			'search_items'       => __('Найти услугу'),
			'not_found'          => __('Услуг не найдено'),
			'not_found_in_trash' => __('В корзине услуг не найдено'),
			'parent_item_colon'  => '',
			'menu_name'          => __('Услуги')

		  ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-businessman',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'supports'           => array('title','editor','author','thumbnail','excerpt')
	) );
}

//регистрируем новый тип записи услуги
add_action('init', 'my_custom_init_partners');
function my_custom_init_partners(){
	register_post_type('partners', array(
		'labels'             => array(
			'name'               => __('Партнеры'), // Основное название типа записи
			'singular_name'      => __('Партнер'), // отдельное название записи типа service
			'add_new'            => __('Добавить нового'),
			'add_new_item'       => __('Добавить нового партнера'),
			'edit_item'          => __('Редактировать партнера'),
			'new_item'           => __('Новый партнер'),
			'view_item'          => __('Посмотреть партнера'),
			'search_items'       => __('Найти партнера'),
			'not_found'          => __('Партнер не найден'),
			'not_found_in_trash' => __('В корзине партнеров не найдено'),
			'parent_item_colon'  => '',
			'menu_name'          => __('Партнеры')

		  ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-groups',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'supports'           => array('title','editor','author','thumbnail','excerpt')
	) );
}

//регистрируем новый тип записи тарифы
add_action('init', 'my_custom_init_price');
function my_custom_init_price(){
	register_post_type('price', array(
		'labels'             => array(
			'name'               => __('Тарифы'), // Основное название типа записи
			'singular_name'      => __('Тариф'), // отдельное название записи типа service
			'add_new'            => __('Добавить новый'),
			'add_new_item'       => __('Добавить новый тариф'),
			'edit_item'          => __('Редактировать тариф'),
			'new_item'           => __('Новый тариф'),
			'view_item'          => __('Посмотреть тариф'),
			'search_items'       => __('Найти тариф'),
			'not_found'          => __('Тариф не найден'),
			'not_found_in_trash' => __('В корзине тарифов не найдено'),
			'parent_item_colon'  => '',
			'menu_name'          => __('Тарифы')

		  ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-money-alt',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 7,
		'supports'           => array('title','editor','author','thumbnail','excerpt','custom-fields')
	) );
}



//регистрируем новый тип записи отзывы 
add_action('init', 'my_custom_init_testimonial');
function my_custom_init_testimonial(){
	register_post_type('testimonial', array(
		'labels'             => array(
			'name'               => __('Отзывы'), // Основное название типа записи
			'singular_name'      => __('Отзыв'), // отдельное название записи типа service
			'add_new'            => __('Добавить новый'),
			'add_new_item'       => __('Добавить новый отзыв'),
			'edit_item'          => __('Редактировать отзыв'),
			'new_item'           => __('Новый отзыв'),
			'view_item'          => __('Посмотреть отзыв'),
			'search_items'       => __('Найти отзыв'),
			'not_found'          => __('отзыв не найден'),
			'not_found_in_trash' => __('В корзине отзывов не найдено'),
			'parent_item_colon'  => '',
			'menu_name'          => __('Отзывы')

		  ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-format-status',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 8,
		'supports'           => array('title','thumbnail','excerpt','custom-fields')
	) );
}

// настройка SMTP
// add_action( 'phpmailer_init', 'smtp_phpmailer_init' );
// function smtp_phpmailer_init( $phpmailer ){

// 	$phpmailer->IsSMTP();

// 	$phpmailer->CharSet    = 'UTF-8';

// 	$phpmailer->Host       = 'smtp.yandex.ru';
// 	$phpmailer->Username   = 'no-reply@mailer.Megasite.com';
// 	$phpmailer->Password   = '6AAAuuSSS2k';
// 	$phpmailer->SMTPAuth   = true;
// 	$phpmailer->SMTPSecure = 'ssl';

// 	$phpmailer->Port       = 465;
// 	$phpmailer->From       = 'no-reply@mailer.Megasite.com';
// 	$phpmailer->FromName   = 'MY-Megasite';

// 	$phpmailer->isHTML( true );
// }

add_action( 'wp_ajax_my_action', 'my_action_callback' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action_callback' );
function my_action_callback() {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

        # Подставляем почту администратора 
        $mail_to = get_option('admin_email');
        
        # Собираем данные с формы
        $phone = trim($_POST["phone"]);
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $message = trim($_POST["message"]);
        
        if ( empty($name) OR empty($email) OR empty($phone) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Пожалуйста заполните все обязательные поля";
            exit;
        }
        
        # Содержимоей письма 
		$subject = 'Заявка с сайта: '. get_bloginfo('name');
        $content = "Name: $name\n";
        $content .= "Email: $email\n\n";
        $content .= "Message:\n$message\n";

        # email headers.
        $headers = "From: wordpress $name <$email>";

        # Попытка отправить письмо с помощью функции mail()
        $success = wp_mail($mail_to,$subject, $phone, $content, $headers);
        if ($success) {
            # Set a 200 (okay) response code.
            http_response_code(200);
            echo "Спасибо! Ваше сообщение отправленно .";
        } else {
            # Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Упс! Что то пошло не так, не получилось отправить.";
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Не получилось отправить попробуйте позже";
    }

	// выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
	wp_die();
}