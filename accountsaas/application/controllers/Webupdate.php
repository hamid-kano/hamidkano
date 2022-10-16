<?php
/**
 * Almusand -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Almusand. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@almusand.com
 *  Website: https://almusand.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Webupdate Extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'misc_settings';


    }

    public function index()
    {
        $head['title'] = "Update";
        $url = file_get_contents(FCPATH . '/version.json');
        $data = json_decode($url, true);

        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('update/update', $data);
        $this->load->view('fixed/footer');

    }

    public function download_update($ver = 0)
    {
        $url = file_get_contents(FCPATH . '/version.json');
        $lic = file_get_contents(APPPATH . '/config/lic.php');
        $version = json_decode($url, true);
        $this->session->set_userdata('build', $version['build']);
        $this->session->set_userdata('step', 0);
        $next_version = $version['build'] + 1;
        $this->session->set_userdata('upto', true);
        $time_temp = rand(19, 999);
        $this->session->set_userdata('temp_id', $time_temp);

        if ($version['build']) {
            echo '<h5>Download Update</h5>';
            echo '<pre>';

            $url = UPDATE_SERVICE;

            $zipFile = 'userfiles' . DIRECTORY_SEPARATOR . 'update_' . $next_version . '_' . $time_temp . '.zip'; // Local Zip File Path
            $zipResource = fopen($zipFile, "w");
// Get The Zip File From Server
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "url=" . urlencode(base_url()) . "&version=" . $version['build'] . "&lic=" . $lic);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_setopt($ch, CURLOPT_FILE, $zipResource);
            $page = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


            if ($httpcode != 404) {
                echo '
        
        License is checked....
        
	';
                echo 'Downloading update files from update server...
        
	';
                if ($httpcode == 503) {
                    fclose($zipResource);
                    chmod(FCPATH . $zipFile, 0755);
                    $this->session->set_userdata('upto', false);
                    @unlink(FCPATH . $zipFile);
                    exit('Your application is already up to date. Version is ' . $version['version'] . ' Build:' . $version['build']);

                } else {
                    echo 'Build ' . $next_version . ' update available. Update files downloaded from server...
            
	';
                    curl_close($ch);

                    echo '
        Extracting downloaded files...
        
	';
                    $extractPath = 'userfiles' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'up' . $next_version . '_' . $time_temp;
                    if (!@mkdir($extractPath, 0777, true)) {

                        if (!file_exists($extractPath)) {
                            echo 'Failed to create the update page, please give appropriate write permissions
                                         to  ' . FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'temp directory  ...
        
	';
                            exit;
                        }
                    }
                    $zip = new ZipArchive;

                    if ($zip->open($zipFile) != "true") {
                        echo "
            Error :- Extracting failed! Limited Permissions 
            
 ";
                        exit('Update Process Halted! Update Extraction failed');
                    }
                    /* Extract Zip File */
                    if ($zip->extractTo($extractPath)) {
                        echo "Success :- Extracting Success!
";
                        echo '</pre>';
                        echo '<h5>Update Downloaded!</h5>';

                    } else {
                        echo '</pre>';
                    }
                }
                $zip->close();
            } else {
                fclose($zipResource);
                chmod(FCPATH . $zipFile, 0755);
                $this->session->set_userdata('upto', false);
                @unlink(FCPATH . $zipFile);
                exit('Invalid License!');
            }
        }

    }

    public function install_update()
    {

        $build = $this->session->userdata('build');
        $upto = $this->session->userdata('upto');
        $temp_id = $this->session->userdata('temp_id');
        $build = $build + 1;
        $zipFile = 'userfiles' . DIRECTORY_SEPARATOR . 'update_' . $build . '_' . $temp_id . '.zip'; // Local Zip File Path
        unlink(FCPATH . $zipFile);
        if ($build && $upto) {

            echo '<h5>Installing Update</h5>';
            echo '<pre  style="height: 100px;overflow: scroll;">';
            echo '
	Updating files in your system... ' . $build . '
	';
            $url = file_get_contents(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'up' . $build . '_' . $temp_id . '' . DIRECTORY_SEPARATOR . 'files.json');
            $files = json_decode($url, true);
            $i = 0;
            $count_f = count($files);
            $b = 0;
            echo 'File backup process started...
	';
            $last_build = $build - 1;
            foreach ($files as $row) {

                echo '
' . FCPATH . $row['path'] . $row['file'] . '
';

                if (@copy(FCPATH . $row['path'] . $row['file'], 'userfiles' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'up' . $build . '_' . $temp_id . '' . DIRECTORY_SEPARATOR . '' . $row['path'] . 'bak_v_' . $last_build . '_' . $row['file'])) {
                    $b++;
                    echo 'Ok
    ';
                } else {
                    if (!is_dir(FCPATH . $row['path'])) {
                        if (mkdir(FCPATH . $row['path'], 0777, true)) {
                            echo 'New Directory Created..' . FCPATH . $row['path'] . '
	';
                        } else {
                            echo 'Error: New Directory Creation..' . FCPATH . $row['path'] . ' Failed!
	';
                            exit('Update Process Halted! Files backup failed');
                        }

                    } else {
                        $z = $b + 1;

                        if (is_file(FCPATH . $row['path'] . $row['file'])) {
                            echo 'Critical Notice: Files backup failed ... File number ' . $z . '
	';
                            exit('Update Process Halted! Files backup failed');
                        } else {
                            echo 'Ordinary Notice: Files backup failed ... File number ' . $z . '
	';
                        }
                    }


                }
            }
//update files
            $f = 0;
            echo '
	File update process started...
	';

            foreach ($files as $row) {

                echo '
' . FCPATH . $row['path'] . $row['file'] . '
';
                if (copy('userfiles/temp/up' . $build . '_' . $temp_id . '/' . $row['path'] . $row['file'], $row['path'] . $row['file'])) {

                    echo 'Ok
    ';

                    $f++;
                } else {
                    $z = $f + 1;
                    echo '
Files update failed ... File number ' . $z . '
	';
                }
            }

            if ($count_f = $f) {
                $this->session->set_userdata('dbupdate', true);
                $this->session->set_userdata('step', 2);
                echo '<h5>Files Updated!</h5>';

            } else {
                echo '
Some Files update failed ... Update Failed!
	';
                exit('Update Process Halted! Files update failed');
            }
        } else {
            exit('Your application is already up to date.');
        }

        echo '
</pre>';
        exit;
    }

    public function update_db()
    {
        ini_set('memory_limit', '-1');
        $ver = $this->session->userdata('build');
        $upto = $this->session->userdata('upto');
        $temp_id = $this->session->userdata('temp_id');
        $ver = $ver + 1;
        if ($ver && $upto) {
            $bdate = 'backup_' . date('Y_m_d_H_i_s');
            $this->load->dbutil();
            $backup = $this->dbutil->backup();
            $this->load->helper('file');
            write_file(FCPATH . 'userfiles/temp/' . $bdate . '.gz', $backup);
            echo '
<pre>';
            echo 'Database Update Process Started...
	';

// Set the url
            $url = file_get_contents(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'up' . $ver . '_' . $temp_id . '' . DIRECTORY_SEPARATOR . 'update_build_' . $ver . '.sql');
            $mysqli = @new mysqli($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
            if (mysqli_connect_errno()) {
                echo json_encode(array("success" => false, "message" => $mysqli->connect_error));
                exit();
            }
            $mysqli->multi_query($url);
            do {
            } while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));
            if ($mysqli->close()) {
                echo 'Database Update Done...
	';
                echo '
</pre>';
                $this->session->set_userdata('step', 0);
            }
        } else {
            exit('Your application is already up to date.');
        }
        exit;
    }
}