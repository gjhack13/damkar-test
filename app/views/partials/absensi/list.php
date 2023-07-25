<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("absensi/add");
$can_edit = ACL::is_allowed("absensi/edit");
$can_view = ACL::is_allowed("absensi/view");
$can_delete = ACL::is_allowed("absensi/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "list-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data From Controller
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Sistem Informasi Absensi Anggota</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("absensi/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add Absensi Anggota 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('absensi'); ?>" method="get">
                        <div class="input-group">
                            <input value="<?php echo get_value('search'); ?>" class="form-control" type="text" name="search"  placeholder="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4.offset-md-3">
                        <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                            <div class="card mb-3">
                                <div class="card-header h4 h4">Tanggal hari ini <?php echo date('d F, Y (l) h:i A') ?></div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 comp-grid">
                        <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                            <div class="card mb-3">
                                <div class="card-header h5 h5">- Group Piket -</div>
                                <div class="p-2">
                                <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Piket Hadir
                                    <span class="badge bg-success rounded-pill">A</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Cadangan Piket
                                    <span class="badge bg-success rounded-pill">B</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Lepas Piket
                                    <span class="badge bg-success rounded-pill">C</span>
                                </li>
                                </ul>
                                    <input class="form-control datepicker"  value="<?php echo $this->set_field_value('absensi_Tanggal_Pinjam') ?>" type="datetime"  name="absensi_Tanggal_Pinjam" placeholder="Silahkan Input Tanggal untuk memfilter..." data-enable-time="" data-date-format="Y-m-d" data-alt-format="M j, Y" data-inline="false" data-no-calendar="false" data-mode="range" />
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group text-center">
                                    <button class="btn btn-primary">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            <div  class="">
                <div class="container-fluid">
                    <div class="row ">
                        <div class="col-md-12 comp-grid">
                            <?php $this :: display_page_errors(); ?>
                            <div class="filter-tags mb-2">
                                <?php
                                if(!empty($_GET['absensi_Tanggal_Pinjam'])){
                                ?>
                                <div class="filter-chip card bg-light">
                                    <b>Sistem Informasi Absensi Anggota Tanggal Absen :</b> 
                                    <?php
                                    $date_val = get_value('absensi_Tanggal_Pinjam');
                                    $formated_date = "";
                                    if(str_contains('-to-', $date_val)){
                                    //if value is a range date
                                    $vals = explode('-to-' , str_replace(' ' , '' , $date_val));
                                    $startdate = $vals[0];
                                    $enddate = $vals[1];
                                    $formated_date = format_date($startdate, 'jS F, Y') . ' <span class="text-muted">&#10148;</span> ' . format_date($enddate, 'jS F, Y');
                                    }
                                    elseif(str_contains(',', $date_val)){
                                    //multi date values
                                    $vals = explode(',' , str_replace(' ' , '' , $date_val));
                                    $formated_arrs = array_map(function($date){return format_date($date, 'jS F, Y');}, $vals);
                                    $formated_date = implode(' <span class="text-info">&#11161;</span> ', $formated_arrs);
                                    }
                                    else{
                                    $formated_date = format_date($date_val, 'jS F, Y');
                                    }
                                    echo  $formated_date;
                                    $remove_link = unset_get_value('absensi_Tanggal_Pinjam', $this->route->page_url);
                                    ?>
                                    <a href="<?php print_link($remove_link); ?>" class="close-btn">
                                        &times;
                                    </a>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div  class=" animated fadeIn page-content">
                                <div id="absensi-list-records">
                                    <div id="page-report-body" class="table-responsive">
                                        <table class="table  table-striped table-sm text-left">
                                            <thead class="table-header bg-light">
                                                <tr>
                                                    <?php if($can_delete){ ?>
                                                    <th class="td-checkbox">
                                                        <label class="custom-control custom-checkbox custom-control-inline">
                                                            <input class="toggle-check-all custom-control-input" type="checkbox" />
                                                            <span class="custom-control-label"></span>
                                                        </label>
                                                    </th>
                                                    <?php } ?>
                                                    <th class="td-sno">#</th>
                                                    <th  class="td-Tanggal_Pinjam"> Tanggal Absen</th>
                                                    <th  class="td-Judul_Acara"> Nama</th>
                                                    <th  class="td-Jumlah_Peserta"> Jabatan</th>
                                                    <th  class="td-Unit_Kerja"> Status Piket</th>
                                                    <th  class="td-Nama_PIC"> Keterangan Izin / Sakit / dll</th>
                                                    <th  class="td-File_Memo"> File Pendukung Absensi</th>
                                                    <th class="td-btn"></th>
                                                </tr>
                                            </thead>
                                            <?php
                                            if(!empty($records)){
                                            ?>
                                            <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                                <!--record-->
                                                <?php
                                                $counter = 0;
                                                foreach($records as $data){
                                                $rec_id = (!empty($data['Tanggal_Pinjam']) ? urlencode($data['Tanggal_Pinjam']) : null);
                                                $counter++;
                                                ?>
                                                <tr>
                                                    <?php if($can_delete){ ?>
                                                    <th class=" td-checkbox">
                                                        <label class="custom-control custom-checkbox custom-control-inline">
                                                            <input class="optioncheck custom-control-input" name="optioncheck[]" value="<?php echo $data['Tanggal_Pinjam'] ?>" type="checkbox" />
                                                                <span class="custom-control-label"></span>
                                                            </label>
                                                        </th>
                                                        <?php } ?>
                                                        <th class="td-sno"><?php echo $counter; ?></th>
                                                        <td class="td-Tanggal_Pinjam"><a href="<?php print_link("ruang_rapat_lantai_2/view/$data[Tanggal_Pinjam]") ?>"><?php echo $data['Tanggal_Pinjam']; ?></a></td>
                                                        <td class="td-Judul_Acara">
                                                            <span  data-pk="<?php echo $data['Tanggal_Pinjam'] ?>" >
                                                                <?php echo $data['Judul_Acara']; ?> 
                                                            </span>
                                                        </td>
                                                        <td class="td-Jumlah_Peserta">
                                                            <span data-value="<?php echo $data['Jumlah_Peserta']; ?>">
                                                                <?php echo $data['Jumlah_Peserta']; ?> 
                                                            </span>
                                                        </td>
                                                        <td class="td-Unit_Kerja">
                                                            <span  data-value="<?php echo $data['Unit_Kerja']; ?>" >
                                                                <?php echo $data['Unit_Kerja']; ?> 
                                                            </span>
                                                        </td>
                                                        <td class="td-Nama_PIC">
                                                            <span  data-value="<?php echo $data['Nama_PIC']; ?>" >
                                                                <?php echo $data['Nama_PIC']; ?> 
                                                            </span>
                                                        </td>
                                                        <td class="td-File_Memo"><?php Html :: page_link_file($data['File_Memo']); ?></td>
                                                        <th class="td-btn">
                                                            <?php if($can_view){ ?>
                                                            <!--<a class="btn btn-sm btn-success has-tooltip" href="<?php print_link("absensi/view/$rec_id"); ?>">
                                                                <i class="fa fa-eye"></i> View
                                                            </a>-->
                                                            <?php } ?>
                                                            <?php if($can_edit){ ?>
                                                            <?php } ?>
                                                            <?php if($can_delete){ ?>
                                                            <!--<a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("absensi/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                                                <i class="fa fa-times"></i>
                                                                Delete
                                                            </a>-->
                                                            <?php } ?>
                                                        </th>
                                                    </tr>
                                                    <?php 
                                                    }
                                                    ?>
                                                    <!--endrecord-->
                                                </tbody>
                                                <tbody class="search-data" id="search-data-<?php echo $page_element_id; ?>"></tbody>
                                                <?php
                                                }
                                                ?>
                                            </table>
                                            <?php 
                                            if(empty($records)){
                                            ?>
                                            <h4 class="bg-light text-center border-top text-muted animated bounce  p-3">
                                                <i class="fa fa-ban"></i> No record found
                                            </h4>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        if( $show_footer && !empty($records)){
                                        ?>
                                        <div class=" border-top mt-2">
                                            <div class="row justify-content-center">    
                                                <div class="col-md-auto justify-content-center">    
                                                    <div class="p-3 d-flex justify-content-between">    
                                                        <?php if($can_delete){ ?>
                                                        <!--<button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("absensi/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
                                                            <i class="fa fa-times"></i> Delete Selected
                                                        </button>-->
                                                        <?php } ?>
                                                        <div class="dropup export-btn-holder mx-1">
                                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-save"></i> Export
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <?php $export_print_link = $this->set_current_page_link(array('format' => 'print')); ?>
                                                                <a class="dropdown-item export-link-btn" data-format="print" href="<?php print_link($export_print_link); ?>" target="_blank">
                                                                    <img src="<?php print_link('assets/images/print.png') ?>" class="mr-2" /> PRINT
                                                                    </a>
                                                                    <?php $export_pdf_link = $this->set_current_page_link(array('format' => 'pdf')); ?>
                                                                    <a class="dropdown-item export-link-btn" data-format="pdf" href="<?php print_link($export_pdf_link); ?>" target="_blank">
                                                                        <img src="<?php print_link('assets/images/pdf.png') ?>" class="mr-2" /> PDF
                                                                        </a>
                                                                        <?php $export_word_link = $this->set_current_page_link(array('format' => 'word')); ?>
                                                                        <a class="dropdown-item export-link-btn" data-format="word" href="<?php print_link($export_word_link); ?>" target="_blank">
                                                                            <img src="<?php print_link('assets/images/doc.png') ?>" class="mr-2" /> WORD
                                                                            </a>
                                                                            <?php $export_csv_link = $this->set_current_page_link(array('format' => 'csv')); ?>
                                                                            <a class="dropdown-item export-link-btn" data-format="csv" href="<?php print_link($export_csv_link); ?>" target="_blank">
                                                                                <img src="<?php print_link('assets/images/csv.png') ?>" class="mr-2" /> CSV
                                                                                </a>
                                                                                <?php $export_excel_link = $this->set_current_page_link(array('format' => 'excel')); ?>
                                                                                <a class="dropdown-item export-link-btn" data-format="excel" href="<?php print_link($export_excel_link); ?>" target="_blank">
                                                                                    <img src="<?php print_link('assets/images/xsl.png') ?>" class="mr-2" /> EXCEL
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">   
                                                                        <?php
                                                                        if($show_pagination == true){
                                                                        $pager = new Pagination($total_records, $record_count);
                                                                        $pager->route = $this->route;
                                                                        $pager->show_page_count = true;
                                                                        $pager->show_record_count = true;
                                                                        $pager->show_page_limit =true;
                                                                        $pager->limit_count = $this->limit_count;
                                                                        $pager->show_page_number_list = true;
                                                                        $pager->pager_link_range=5;
                                                                        $pager->render();
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
