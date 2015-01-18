<?php
    $this->title = 'Конструктор схемы страницы';
?>

<h2>Конструктор схемы страницы</h2>
<div class="container">
    <div class="row">
        <div class="col-md-12">            
            <div id="land-draw-area"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">                        
            <p>                
                <div class="btn-group">                                        
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="size-select-bt">
                            <span class="size-select-bt-text">Размер..</span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" id="size-select-menu" role="menu">
                            <?php for($i=1; $i<=12; $i++): ?>
                            <li><a href="#">col-<?=$i;?></a></li>
                            <?php endfor; ?>
                        </ul>                        
                    </div>
                    <button type="button" class="btn btn-success" id="land-add-block-bt">Добавить</button>
                </div>
            </p>            
            <!--<button type="button" class="btn btn-danger btn-sm" id="land-del-block-bt">Удалить</button>-->
        </div>
    </div>
</div>