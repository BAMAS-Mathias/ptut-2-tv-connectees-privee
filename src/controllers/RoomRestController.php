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
                array(
                    'methods' => \WP_REST_Server::EDITABLE,
                    'callback' => array($this, 'update_room'),
                    'args' => array(
                        'pcCount' => array(
                            'type' => 'number',
                            'description' => __('Number of pc available'),
                        ),
                        'projector' => array(
                            'type' => 'string',
                            'description' => __('Is there a projector'),
                        ),
                        'chairCount' => array(
                            'type' => 'number',
                            'description' => __('Number of place available'),
                        ),
                        'connection' => array(
                            'type' => 'string',
                            'description' => __('Connection type available'),
                        ),
                    ),
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


    /**
     * Update a room
     *
     * @param \WP_REST_Request $request Full data about the request.
     * @return \WP_Error|\WP_REST_Response
     */
    public function update_room($request){

        return new \WP_REST_Response(array("good"), 200);
    }

}