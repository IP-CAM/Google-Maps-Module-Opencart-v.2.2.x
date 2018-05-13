<?php
class ControllerModuleGoogleMap extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('module/google_map');
        $this->load->model('tool/image');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_extension_module->addModule('google_map', $this->request->post);
            } else {
                $this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_thumb'] = $this->language->get('text_thumb');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_api_key'] = $this->language->get('entry_api_key');
        $data['entry_lat'] = $this->language->get('entry_lat');
        $data['entry_lng'] = $this->language->get('entry_lng');
        $data['entry_height'] = $this->language->get('entry_height');
        $data['entry_width'] = $this->language->get('entry_width');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        if (isset($this->error['api_key'])) {
            $data['error_api_key'] = $this->error['api_key'];
        } else {
            $data['error_api_key'] = '';
        }

        if (isset($this->error['lat'])) {
            $data['error_lat'] = $this->error['lat'];
        } else {
            $data['error_lat'] = '';
        }

        if (isset($this->error['lng'])) {
            $data['error_lng'] = $this->error['lng'];
        } else {
            $data['error_lng'] = '';
        }

        if (isset($this->error['height'])) {
            $data['error_height'] = $this->error['height'];
        } else {
            $data['error_height'] = '';
        }

        if (isset($this->error['width'])) {
            $data['error_width'] = $this->error['width'];
        } else {
            $data['error_width'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
        );

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('module/google_map', 'token=' . $this->session->data['token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('module/google_map', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('module/google_map', 'token=' . $this->session->data['token'], true);
        } else {
            $data['action'] = $this->url->link('module/google_map', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['api_key'])) {
            $data['api_key'] = $this->request->post['api_key'];
        } elseif (!empty($module_info)) {
            $data['api_key'] = $module_info['api_key'];
        } else {
            $data['api_key'] = '';
        }

        if (isset($this->request->post['lat'])) {
            $data['lat'] = $this->request->post['lat'];
        } elseif (!empty($module_info)) {
            $data['lat'] = $module_info['lat'];
        } else {
            $data['lat'] = '';
        }

        if (isset($this->request->post['lng'])) {
            $data['lng'] = $this->request->post['lng'];
        } elseif (!empty($module_info)) {
            $data['lng'] = $module_info['lng'];
        } else {
            $data['lng'] = '';
        }

        if (isset($this->request->post['height'])) {
            $data['height'] = $this->request->post['height'];
        } elseif (!empty($module_info)) {
            $data['height'] = $module_info['height'];
        } else {
            $data['height'] = '400px';
        }

        if (isset($this->request->post['width'])) {
            $data['width'] = $this->request->post['width'];
        } elseif (!empty($module_info)) {
            $data['width'] = $module_info['width'];
        } else {
            $data['width'] = '100%';
        }

        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($module_info)) {
            $data['image'] = $module_info['image'];
        } else {
            $data['image'] = '';
        }

        if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 50, 50);
        } elseif (!empty($module_info['image']) && is_file(DIR_IMAGE . $module_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($module_info['image'], 50, 50);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 50, 50);
        }

        $data['placeholder_thumb'] = $this->model_tool_image->resize('no_image.png', 50, 50);

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/google_map.tpl', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/google_map')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if ((utf8_strlen($this->request->post['api_key']) < 12) || (utf8_strlen($this->request->post['api_key']) > 100)) {
            $this->error['api_key'] = $this->language->get('error_api_key');
        }

        if (!(float)$this->request->post['lat']) {
            $this->error['lat'] = $this->language->get('error_lat');
        }

        if (!(float)$this->request->post['lng']) {
            $this->error['lng'] = $this->language->get('error_lng');
        }

        if (!preg_match('/^[0-9\.]+(px|%)$/', $this->request->post['height'])) {
            $this->error['height'] = $this->language->get('error_height');
        }

        if (!preg_match('/^[0-9\.]+(px|%)$/', $this->request->post['width'])) {
            $this->error['width'] = $this->language->get('error_width');
        }

        return !$this->error;
    }
}
