<?php
/**
 * WC Filter Migration Migrate.
 *
 * @since   0.0.0
 * @package WC_Filter_Migration
 */

/**
 * WC Filter Migration Migrate.
 *
 * @since 0.0.0
 */
class WCFM_Migrate {
	/**
	 * Parent plugin class
	 *
	 * @var   WC_Filter_Migration
	 *
	 * @since 0.0.0
	 */
	protected $plugin = null;

	/**
	 * Constructor.
	 *
	 * @since  0.0.0
	 *
	 * @param  WC_Filter_Migration $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		// If we have WP CLI, add our commands.
		if ( $this->verify_wp_cli() ) {
			$this->add_commands();
		}
	}

	/**
	 * Check for WP CLI running.
	 *
	 * @since  0.0.0
	 *
	 * @return boolean True if WP CLI currently running.
	 */
	public function verify_wp_cli() {
		return ( defined( 'WP_CLI' ) && WP_CLI );
	}

	/**
	 * Add our commands.
	 *
	 * @since  0.0.0
	 */
	public function add_commands() {
		WP_CLI::add_command( 'wc_filter_migration', array( $this, 'wc_filter_migration_command' ) );
	}

	/**
	 * Create a method stub for our first CLI command.
	 *
	 * @since 0.0.0
	 */
	public function wc_filter_migration_command($args) {

		
		if(count($args)<2){

			echo "enter post id of filter to copy settings from";
			return;
		}

		$template_filter_id = $args[0];
		$filter_group_id = $args[1];




		$filters = get_posts([
			'post_type'=>'wcpf_item',
			'posts_per_page'=>-1,
			'orderby'=>'menu_order',
			'order'=>'asc'
		]);
		$new_filters  = [];
		$template_post = get_post($args[0]);
		$template = get_post_meta( $args[0], 'br_product_filter', true );
		foreach($filters as $filter_post) {

			if($filter_post->post_title === $template_post->post_title){
				continue;
			}

			$type = get_post_meta( $filter_post->ID, 'wcpf_entity_key', true );
			if ( $type !== 'CheckBoxListField' ) {
				continue;
			}

			$options = get_post_meta( $filter_post->ID, 'wcpf_entity_options', true );


			$source    = $options['itemsSource'];
			$attribute = isset( $options['itemsSourceAttribute'] ) ? $options['itemsSourceAttribute'] : false;
//			$key       = $options['optionKey'];
			$type      = $options['queryType'];
			$d_rule = [];
			if(isset($options['displayRules'])){
				$display_rules = $options['displayRules'];



			foreach($display_rules as $rules){

					foreach($rules['rules'] as $r){
						$rule = $r['rule'];
						if(isset($rule['value']) && !empty($rule['value'])){
						$d_rule = $rule;

						}
					}

			}

			}

					$filter_options = unserialize(serialize($template));

			if(!empty($d_rule)){

					$equal = 'equal';
					if($d_rule['operator']==='=='){
						$equal = 'equal';
					}elseif($d_rule['operator']==='!='){
						$equal = 'not_equal';
					}
					$category = $d_rule['value'];

				$filter_options['data'] =[
				[	[
						'equal'=>$equal,
						'category'=>[$category],
						'type'=>'woo_category'
					]]
				];

			}

					$filter_options['filter_type'] = $source;
					if($attribute){
						if(strpos($attribute, 'pa_')===false){
							$attribute = 'pa_' . $attribute;
						}
						$filter_options['attribute'] =  $attribute;
					}else{
						unset($filter_options['attribute']);
					}
					$filter_options['operator'] = strtoupper($type);

					$filter_options['filter_title'] = $filter_post->post_title;

				$new_filters[] = 		wp_insert_post([
						'post_title'=>$filter_post->post_title,
						'post_name'=>$filter_post->post_name,
						'post_status'=>'publish',
						'post_type'=>'br_product_filter',
						'meta_input'=>[
							'br_product_filter'=>$filter_options
						]
					]);
		}

$group_data = get_post_meta($filter_group_id, 'br_filters_group', true);
$group_data['filters'] = array_merge($group_data['filters'], $new_filters);

update_post_meta($filter_group_id, 'br_filters_group', $group_data);

	}
}
