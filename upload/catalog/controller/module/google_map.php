<?php

class ControllerModuleGoogleMap extends Controller
{
    public function index($setting)
    {
        static $module = 0;

        $this->load->model('tool/image');

        $data['status']  = $setting['status'];
        $data['api_key'] = $setting['api_key'];
        $data['lat']     = $setting['lat'];
        $data['lng']     = $setting['lng'];
        $data['height']  = $setting['height'];
        $data['width']   = $setting['width'];
        $data['module']  = $module++;

        $marker = $setting['image'];
        if (!empty($marker) && is_file(DIR_IMAGE . $marker)) {
            $data['map_icon'] = $this->model_tool_image->resize($marker, 50, 50);
        } else {
            $data['map_icon'] = '';
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/google_map.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/module/google_map.tpl', $data);
        } else {
            return $this->load->view('default/template/module/google_map.tpl', $data);
        }
    }
}
