<?php

/**
 * Created by PhpStorm.
 * User: cestrada
 * Date: 23/02/2017
 * Time: 3:14 PM
 */
class SMS_views extends SMS
{

    public function get_Cursos()
    {
        $arrCursos = $this->get_list_cursos();

        //bin_debug($arrCursos);
        ?>
        <h1>Cursos</h1>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4 py-3 border-bottom-primary">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Curso</th>

                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($arrCursos as $key => $dataArray) {
                                    ?>
                                    <tr>
                                        <td><?php print $dataArray['nombreCurso'] ?></td>
                                        <td class="text-right py-0 align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>

                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                    ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
