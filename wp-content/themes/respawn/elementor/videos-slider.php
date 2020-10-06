<?php

namespace Elementor;

if (!defined('ABSPATH')) exit; // Exit if accessed directly


/**
 * Videos slider.
 *
 * Elementor widget that displays set of videos in slick slider.
 *
 * Class Widget_post_slider
 * @package Elementor
 */
class Widget_SW_Videos_Slider extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve videos slider widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'videos_slider';
    }

    /**
     * Get widget title.
     *
     * Retrieve videos slider widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('SW - Videos Slider', 'respawn');
    }

    /**
     * Retrieve the list of scripts the videos slider widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return ['respawn_elementor_minified', 'respawn_elementor_sliders'];
    }


    /**
     * Get widget category
     * @return array
     */
    public function get_categories()
    {
        return ['skywarrior'];
    }

    /**
     * Get widget icon.
     *
     * Retrieve videos slider widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        // Icon name from the Elementor font file, as per https://pojome.github.io/elementor-icons/
        return 'eicon-slider-video';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ['video', 'carousel', 'slider'];
    }

    /**
     * Register videos slider widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_videos_slider_content',
            [
                'label' => esc_html__('Content', 'respawn'),
            ]
        );

        $this->add_control(
            'header',
            [
                'label' => esc_html__('Header', 'respawn'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__('Add header', 'respawn'),
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'respawn'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__('Add text', 'respawn'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button text', 'respawn'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__('Add button text', 'respawn'),
            ]
        );

        $this->add_control(
            'url',
            [
                'label' => esc_html__( 'Button Link', 'respawn' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'respawn' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'hr',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );


        $this->add_control(
            'twitch_api',
            [
                'label' => esc_html__('Twitch client id', 'respawn'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__('Add client id if you want to use Twitch videos', 'respawn'),
            ]
        );

        $this->add_control(
            'hr2',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'video_url', [
                'label' => esc_html__('URL', 'respawn'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Video url', 'respawn'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'video_cover', [
                'label' => esc_html__('Cover image', 'respawn'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__('Videos List', 'respawn'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => esc_html__('URL #1', 'respawn'),
                        'list_content' => esc_html__('Video URL. Click the edit button to change this URL.', 'respawn'),
                    ],
                ],
                'title_field' => '{{{ video_url }}}',
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render posts slider widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        //Get values (in array "settings")
        $settings = $this->get_settings();

        $slick = '{"adaptiveHeight": true, "variableWidth": true,  "centerPadding": "60px","slidesToShow": 3,"infinite": true, "responsive": [{"breakpoint": 1024,"settings": {"slidesToShow": 2,"slidesToScroll": 2,"infinite": true, "dots": false,"variableWidth": true}},{ "breakpoint": 768,"settings": {"slidesToShow": 1,"slidesToScroll": 1,"variableWidth": false, "dots": false}}] }';

        $target = $settings['url']['is_external'] ? ' target=_blank' : '';
        $nofollow = $settings['url']['nofollow'] ? ' rel=nofollow' : '';
        $empty = '';

        if ($settings['list']) { ?>

            <?php if(!empty($settings['header']) or !empty($settings['text']) or !empty($settings['url']['url'])){ ?>
                <div class="vh-wrap">
                    <?php if(!empty($settings['header'])){ ?>
                        <h6><?php echo esc_html($settings['header']); ?></h6>
                    <?php } ?>

                    <?php if(!empty($settings['text'])){ ?>
                        <h2><?php echo esc_html($settings['text']); ?></h2>
                    <?php } ?>

                    <?php if(!empty($settings['url']['url'])){ ?>
                        <a href="<?php echo esc_url($settings['url']['url']);  ?>" <?php echo esc_attr($nofollow); ?>  <?php echo esc_attr($target); ?> class="btn">
                            <?php echo esc_html($settings['button_text']); ?>
                        </a>
                    <?php } ?>
                </div>
            <?php }else{
                $empty = 'vh-wrap-none';
            } ?>

            <div data-slick='<?php echo esc_attr($slick); ?>' class="video-slider center ns-secondstyle slick-arrows-fix <?php echo esc_attr($empty); ?>">



                <?php foreach ($settings['list'] as $item) {

                    $rand = rand(0, 999);
                    $image = '';

                    $youtube = false;
                    if( strpos( $item['video_url'], 'youtube' ) !== false )
                        $youtube = true;

                    $vimeo = false;
                    if( strpos( $item['video_url'], 'vimeo' ) !== false )
                        $vimeo = true;

                    $twitch = false;
                    if( strpos( $item['video_url'], 'twitch' ) !== false )
                        $twitch = true;

                    if($youtube){

                        if(!empty($item['video_cover']['url'])){
                            $image_link = respawn_aq_resize( $item['video_cover']['url'], 940, 620, true, true, true );
                            $image = $image_link;
                        }else{
                            $id = substr($item['video_url'], strpos($item['video_url'], "v=") + 2);
                            $image = 'https://img.youtube.com/vi/'.$id.'/0.jpg';
                        }
                    }

                    if($vimeo){
                        if(!empty($item['video_cover']['url'])){
                            $image_link = respawn_aq_resize( $item['video_cover']['url'], 940, 620, true, true, true );
                            $image = $image_link;
                        }else{
                            $id = substr($item['video_url'], strpos($item['video_url'], "com/") + 4);
                            $image = 'https://i.vimeocdn.com/video/'.$id.'_640.jpg';
                        }
                    }

                    if($twitch){
                        if(!empty($item['video_cover']['url'])){
                            $image_link = respawn_aq_resize( $item['video_cover']['url'], 940, 620, true, true, true );
                            $image = $image_link;
                        }else{
                            $id = substr($item['video_url'], strpos($item['video_url'], "video=v") + 7);
                            $json = '';
                           // $json = file_get_contents('https://api.twitch.tv/kraken/videos/'.$id.'?client_id='.$settings['twitch_api']);
                            $obj = json_decode($json);
                            $image = $obj->thumbnails[0]->url;
                        }
                    }

                    if(empty($image) or !isset($image)) $image = get_theme_file_uri('assets/img/defaults/default.jpg');

                    ?>

                    <div class="blogs-style1 spcard">
                        <a href="<?php echo esc_url($item['video_url']); ?>" rel="prettyPhoto[pp_gal<?php echo esc_attr($rand); ?>]">
                            <img alt="<?php the_title_attribute(); ?>" src="<?php echo esc_url($image); ?>" />
                        </a>
                    </div>

                <?php } ?>

            </div>

            <?php

        }

    }

}