@extends('layouts.client')
@section('content')
<br>

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <hr style="    border-top: 1px solid #8c8c8c;">
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="row">
            <div class="col-lg-7">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active text-center">
                            <!--<img src="http://via.placeholder.com/950x400" alt="">-->
                            <img src="{{url($product->image)}}" alt="" width="80%" style="padding-left: 20%">
                            <div class="carousel-caption">
                            </div>
                        </div>

                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row" style="padding-bottom: 5%">
                            <div class="col-lg-12" style="color:#979797;font-size: 18px;font-weight: 400">
                                {{ucwords($supplier["business"])}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="font-size: 18px;font-weight: 400">
                                {{ucwords($product->title)}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="text-muted">Unidades {{$product->units_sf}} &nbsp;
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </h4>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">

                        <h4>Description</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <input type="hidden" id="product_id" name="product_id" value="{{$product->id}}">
                        {{$product->short_description}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <h4 style="color:#434141">Precio $ {{number_format($product->price_sf,2,",",".")}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="text-muted">Codigo: {{$product->reference}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Cantidad X{{$product->packaging}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <input class="form-control" id="quantity" name="quantity" value="1" type="number" min="1">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3">
                        <button class="btn btn-success form-control" id="AddProduct">Comprar</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true" style='cursor: pointer'></span>&nbsp;<span class="badge">42</span>&nbsp;&nbsp;
                        <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true" style='cursor: pointer'></span>&nbsp;<span class="badge">0</span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="glyphicon glyphicon-comment" aria-hidden="true" style='cursor: pointer' onclick="obj.modalComment({{$product->id}})"></span>&nbsp;<span class="badge" >0</span>
                    </div>
                </div>
            </div>        
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-muted">Productos Relacionados</h    2>
            </div>
        </div>

        <div class="row row-space">
            <div class="col-lg-12">
                <div class="carousel slide media-carousel" id="newproducts">
                    <div class="carousel-inner">
                        <div class="item  active">
                            <div class="row" style="padding-top: 2%;padding-bottom: 2%">
                                <?php
                                $cont = 0;
                                foreach ($relations as $i => $val) {
                                    ?>
                                    <div class="col-sm-3 col-lg-2 col-md-3">
                                        <div class="thumbnail">
                                            <img src="{{url($val->thumbnail)}}">
                                            <div class="caption">
                                                <h5 class="text-center"><a href="/productDetail/{{$val->id}}">{{$val->title}}</a></h5>
                                                <p>
                                                <h4 class="text-center">$ {{number_format($val->price_sf,2,",",".")}}</h4>
                                                </p>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <a href="/productDetail/{{$val->id}}" class="btn btn-success form-control">Comprar</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $cont++;
                                    if ($cont == 6) {
                                        $cont = 0;
                                        ?>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <a class="left carousel-control" href="#newproducts" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#newproducts" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
<!--        <div class="row">
            <div class="col-lg-12">
                <div style="background:#fffcf8;width: 100%;">
                    <div class="row " style="padding-top: 20px;padding-left:50px;padding-right:50px;">
                        @if (count($relations)>0)
                        <?php
                        $cont = 0;
                        ?>
                        @foreach($relations as $i => $val)

                        <div class="col-sm-3 col-lg-3 col-md-3">
                            <div class="thumbnail">
                                <img src="{{url($val->thumbnail)}}">
                                <div class="caption">
                                    <h5 class="text-center"><a href="/productDetail/{{$val->id}}">{{$val->title}}</a></h5>
                                    <p>
                                    <h4 class="text-center">$ {{number_format($val->price_sf,2,",",".")}}</h4>
                                    </p>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href="/productDetail/{{$val->id}}" class="btn btn-success form-control">Comprar</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                        $cont++;
                        if ($cont == 4) {
                            $cont = 0;
                            ?>
                        </div>
                        <div class="row" style="padding-top: 20px;padding-left:50px;padding-right:50px;">
                            <?php
                        }
                        ?>
                        @endforeach
                        @else
                        <div class="col-sm-3 col-lg-3 col-md-3">Dont found</div>
                        @endif

                    </div>
                </div>
            </div>
        </div>-->
    </div>

</div>

<div class="modal fade" role="dialog" id='modalComment'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Comentarios</h4>
            </div>
            <div class="modal-body">
                <form id="frmComment">
                    <div class="row">
                        <div class="col-lg-12">
                            <textarea class="form-control" id="txtCommnet"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success">Enviar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{!!Html::script('js/Ecommerce/detailProduct.js')!!}
@endsection