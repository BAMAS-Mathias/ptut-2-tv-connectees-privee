<?php

namespace Controllers;
use Models\RoomRepository;

class RoomRestController extends \WP_REST_Controller {

    public function __construct() {
        $this->namespace = 'amu-ecran-connectee/v1';
        $this->rest_base = 'room';
    }

    public function register_routes(){
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            array(
                array(
                    'methods' => \WP_REST_Server::READABLE,
                    'callback' => array($this, 'get_room'),
                    'args' => $this->get_collection_params(),
                ),
                'schema' => array($this, 'get_public_item_schema'),
            )
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>[\w]+)',
            array(
                'args' => array(
                    'id' => array(
                        'description' => __('Unique identifier for the information'),
                        'type' => 'integer',
                    ),
                ),
                array(
                    'methods' => \WP_REST_Server::READABLE,
                    'callback' => array($this, 'get_room'),
                    'args' => null,
                ),
                'schema' => array($this, 'get_public_item_schema'),
            )
        );
    }

    /**
     * Get a room
     *
     * @param \WP_REST_Request $request Full data about the request.
     * @return \WP_Error|\WP_REST_Response
     */
    public function get_room($request){
        $room = (new RoomRepository())->getRoom($request['id']);

        if(!$room){
            return new \WP_REST_Response(array('message' => 'Information not found'), 404);
        }

        return new \WP_REST_Response(array($room), 200);
    }

}