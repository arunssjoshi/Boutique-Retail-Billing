@extends('layout.admin.default')
@section('content')
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Batches
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo admin_dashboard_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li class="active">Batches</li>
                        
                    </ol>
                </section>
<?php //var_dump($batch_details); //exit;?>
                <!-- Main content -->
                <section class="content">
                <!-- box start -->
                    <div class="box">
                                
                        <div class="box-body table-responsive">
                           <div class="row marginBottom10 width90pc">
                               <div class="col-md-1"> Batch:</div>
                               <div class="col-md-8">  <?php echo $batch_info->batch;?></div>
                               <div class="clear"></div>
                           </div>
                           <div class="row marginBottom10 width90pc">
                               <div class="col-md-1">  Date: </div>
                               <div class="col-md-8"> <?php echo date('l, jS F Y',strtotime($batch_info->purchased_on));?></div>
                               <div class="clear"></div>
                           </div>
                           <div class="row marginBottom10 width90pc">
                               <div class="col-md-1"> City:</div>
                               <div class="col-md-8"> <?php echo $batch_info->city;?> </div>
                               <div class="clear"></div>
                           </div>
                           <div class="row marginBottom10 width90pc">
                               <div class="col-md-1"> Shops: </div>
                               <div class="col-md-8">  <?php echo $batch_info->shops;?></div>
                               <div class="clear"></div>
                           </div>
                           <div class="row marginBottom10 width90pc">
                               <div class="col-md-1"> Description: </div>
                               <div class="col-md-8"> <?php echo $batch_info->description;?>  </div>
                               <div class="clear"></div>
                           </div>
                           <div class="row marginBottom10 width90pc">
                               <div class="col-md-1"> Summary: </div>
                               <div class="col-md-8"> 
                                    Total Purchase: Rs. <strong><?php echo number_format($batch_total_purchase_amount);?>/-</strong>   &nbsp;&nbsp;&nbsp;
                                    Total Sales: Rs. <strong><?php echo number_format($total_sold_amount);?>/-</strong>  
                                    (<?php echo !empty($batch_total_purchase_amount)?number_format(($total_sold_amount/$batch_total_purchase_amount)*100,2):0?> %)&nbsp;&nbsp;&nbsp;
                                    In Stock: Rs. <?php echo number_format($batch_total_purchase_amount - $total_sold_amount);?>/-
                                </div>
                               <div class="clear"></div>
                           </div>
                           <div class="row marginBottom10 width90pc"></div>
                               <div class="clear"></div>
                           </div>
                           <div class="row marginBottom10 width90pc">
                               <div class="col-md-6">
                                    

                                    <table class="table table-bordered table-striped dataTable no-footer" id="tblBatchDetails" role="grid" aria-describedby="tblShops_info" style="width: 1313px;">
                                        
                                        <thead>
                                            <tr role="row">
                                                <th colspan="4" class="darkRow" aria-sort="ascending" >Purchases</th>
                                                <th colspan="2" class="darkRow" >Sales</th>
                                            </tr>
                                            <tr role="row">
                                                <th  style="width: 91px;" aria-sort="ascending" >Category</th>
                                                <th  style="width: 84px;" >Shop</th>
                                                <th  style="width: 56px;" >Total Items </th>
                                                <th  style="width: 32px;" >Purchased Price</th>
                                                <th  style="width: 56px;" >Total Items </th>
                                                <th  style="width: 32px;" >Sold Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php if ($batch_details['total_rows'] > 0):
                                                $category = '';
                                                $total_item_purchased = 0;
                                                $total_amount_purchased = 0;
                                                $total_item_sold = 0;
                                                $total_amount_sold = 0;
                                            ?>
                                                <?php foreach ($batch_details['items'] as $batch_item):
                                                    
                                                ?>
                                                    <?php if($category!='' && $category != $batch_item->category):?>
                                                        <tr role="row" class="odd trDetails">
                                                            <td class="tdDetails"><?php echo $category;?></td>
                                                            <td>All Shops</td>
                                                            <td>  <?php echo $total_item_purchased;?> Nos</td>
                                                            <td>  Rs. <?php echo number_format($total_amount_purchased);?></td>
                                                            <td>  <?php echo $total_item_sold;?> Nos (<?php echo !empty($total_item_purchased)?number_format(($total_item_sold/$total_item_purchased)*100
                                                            ,2):0?> %)</td>
                                                            <td>  Rs.<?php echo number_format($total_amount_sold);?></td>
                                                        </tr>
                                                    <?php 
                                                        $total_item_purchased = 0; 
                                                        $total_amount_purchased = 0;
                                                        $total_item_sold = 0;
                                                        $total_amount_sold = 0;
                                                    endif;?>
                                                    <tr role="row" class="odd">
                                                        <td class="sorting_1"><?php echo $batch_item->category;?></td>
                                                        <td><?php echo $batch_item->shop;?></td>
                                                        <td><?php echo $batch_item->total_item_purchased;?></td>
                                                        <td><?php echo $batch_item->purchase_price;?></td>
                                                        <td>
                                                            <?php echo $batch_item->sales->total_item_sold;?> 
                                                            (<?php echo !empty($batch_item->total_item_purchased)?number_format(($batch_item->sales->total_item_sold/$batch_item->total_item_purchased)*100
                                                            ,2):0?> %)
                                                        </td>
                                                        <td><?php echo $batch_item->sales->total_sold_price;?></td>
                                                        <!-- <td><a href="http://billing.lh/admin/batch/details/7"><small class="badge  bg-aqua"><i class="fa fa-pencil"></i> Details</small></a></td> -->
                                                    </tr>

                                                    <?php 
                                                        $category = $batch_item->category;
                                                        $total_item_purchased = $total_item_purchased+ $batch_item->total_item_purchased;
                                                        $total_amount_purchased = $total_amount_purchased+ $batch_item->purchase_price;

                                                        $total_item_sold = $total_item_sold+ $batch_item->sales->total_item_sold;
                                                        $total_amount_sold = $total_amount_sold+ $batch_item->sales->total_sold_price;
                                                        
                                                    //if ()
                                                    ?>
                                                <?php endforeach;?>
                                                <tr role="row" class="odd trDetails">
                                                    <td class="tdDetails"><?php echo $category;?></td>
                                                    <td>All Shops</td>
                                                    <td>  <?php echo $total_item_purchased;?></td>
                                                    <td> Rs. <?php echo number_format($total_amount_purchased);?></td>
                                                    <td>  <?php echo $total_item_sold;?> Nos (<?php echo !empty($total_item_purchased)?number_format(($total_item_sold/$total_item_purchased)*100
                                                            ,2):0?> %)</td>
                                                    <td> Rs. <?php echo number_format($total_amount_sold);?></td>
                                                </tr>
                                            <?php endif;?>
                                        </tbody>
                                    </table>


                               </div>
                               <div class="col-md-6">
                                   
                               </div>
                               <div class="clear"></div>
                           </div>

                            <div class="clear"></div>
                            
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                <!-- box end -->
                
                </section><!-- /.content -->
                

@stop
