<!-- Modal view -->

<div id="viewModal" class="modal fade bs-example-modal-lg" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" title="Cerrar" class="close" data-dismiss="modal"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt="Cerrar"></button>
                <button type="button" title="Editar" id="update" data-dismiss="modal" class="updModal close"><i class="icon-update edit"></i></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body">
                <div id='vista'></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal update -->

<div id="updateModal" class="modal fade bs-example-modal-lg" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" title="Cerrar" class="close" data-dismiss="modal"><img src="<?=Yii::$app->request->baseUrl;?>/images/iconos/IconoBarraCerrar.png" alt=""></button>
                <button type="button" title="Ver" id="view" data-dismiss="modal" class="verModal close"><i class="icon-view edit"></i></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body">
                <div id='act'></div> 
            </div>
        </div>
    </div>
</div>