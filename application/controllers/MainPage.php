<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MainPage extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ripcord/ripcord');
        $this->load->library('pagination');
        $this->load->helper('response');
        $this->load->config('odoo');
    }
    public function index()
    {

        $url = 'https://fastprintid-fastprint-izi-11383317.dev.odoo.com';
        $db = "fastprintid-fastprint-izi-11383317";
        $email = "prog4.fastprintsby@gmail.com";
        $password = "hubla";
        $common = ripcord::client("$url/xmlrpc/2/common");
        $uid = $common->authenticate($db, $email, $password, []);
        $obj = ripcord::client("$url/xmlrpc/object");

        if (!empty($this->session->userdata('filter'))) {
            $id_cabang = $this->session->userdata('filter');
            if ($id_cabang == 1) {
                $cabang = [8, 7, 6];
            } else {
                $cabang = [(int)$id_cabang];
            }
        } else {
            $cabang = [8, 7, 6];
        }

        $domain = array(
            array("type", "in", array("consu", "product")),
            array("categ_id", "ilike", "JD"),
        );
        if (!empty($this->session->userdata('search'))) {
            $search = $this->session->userdata('search');
            $array_search = preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($array_search as $key => $data1) {
                $domain = array_merge(
                    $domain,
                    array(
                        "|",
                        "|",
                        "|",
                        array("barcode", "ilike", $data1),
                        array("name", "ilike", $data1),
                        array("product_variant_ids.default_code", "ilike", $data1),
                        array("default_code", "ilike", $data1),
                    )
                );
            }

        } else {
            $domain = [
                ["type", "in", ["consu", "product"]],
                ["categ_id", "ilike", "JD"],
            ];
        }

        $count_products = $obj->execute_kw($db, $uid, $password, 'product.template', 'search_count', [$domain]);

        $config["base_url"] = base_url('index');
        $config["total_rows"] = $count_products;
        $config["per_page"] = 10;
        $config["uri_segment"] = 2;
        $page = ($this->uri->segment(2)) ? (int)$this->uri->segment(2) : 0;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $kwargs = ['context' => ['allowed_company_ids' => $cabang], 'order' => 'name asc', 'limit' => $config["per_page"], 'offset' => $page, 'domain' => $domain, 'fields' => ['product_variant_ids', 'name', 'categ_id', 'qty_available']];
        $products = $obj->execute_kw($db, $uid, $password, 'product.template', 'search_read', [], $kwargs);

        $domain_report = [
            ["state", "=", "done"],
            ["date", ">=", "2023-11-22"]
        ];
        $context_report = [
            'allowed_company_ids' => $cabang,
            'search_default_done' => 1,
            'search_default_filter_last_12_months' => 1,
            'search_default_groupby_product_id' => 1,
            'uid' => 6

        ];
        $kwargs_report = ['context' => $context_report, 'domain' => $domain_report, 'fields' => ['product_id', 'date', 'qty_done']];
        $reports = $obj->execute_kw($db, $uid, $password, 'stock.move.line', 'search_read', [], $kwargs_report);
        $data['products'] = $products;
        $data['reports'] = array();

        foreach ($products as $key => $product) {
            $data['products'][$key][11] = 0;
            $data['products'][$key][12] = 0;
            $data['products'][$key][1] = 0;
            foreach ($reports as $index => $report) {


                if ($product['product_variant_ids'][0] == $report['product_id'][0]) {
                    $date = date_parse_from_format("Y-m-d H:i:s", $report['date']);
                    $data['products'][$key][$date['month']] = $data['products'][$key][$date['month']] + $report['qty_done'];
                }
            }
        }
        $data['session_cabang'] = $this->session->userdata('filter');
        $data['data_cabang'] = array(
            ['name' => 'Semua Cabang', 'id' => 1],
            ['name' => 'Jakarta', 'id' => 8],
            ['name' => 'Bandung', 'id' => 7],
            ['name' => 'Surabaya', 'id' => 6],
        );

        $this->_load_view($data);
    }

    public function search()
    {
        $search = $this->input->post('search');
        $filter = $this->input->post('cabang');
        if (!empty($search)) {
            $this->session->unset_userdata('search');
            $this->session->set_userdata(array('search' => $search));
        } else {
            $this->session->unset_userdata('search');
        }
        if (!empty($filter)) {
            $this->session->unset_userdata('filter');
            $this->session->set_userdata(array('filter' => $filter));
        } else {
            $this->session->unset_userdata('filter');
        }
        redirect('index');
    }

    private function _load_view($data)
    {
        $this->load->view('pages/header');
        $this->load->view('pages/navbar');
        $this->load->view('pages/index', $data);
        $this->load->view('pages/footer');
    }
}
