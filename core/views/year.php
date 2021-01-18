<div style="margin:0 auto; font-family: 'Segoe UI';  width: 100%; display: flex; flex-direction: column; align-items: center; height: 96vh" >
    <label style="margin: 0 auto">
        <?

        ?>
        <select name="month" style="font-family: 'Segoe UI'; font-size:16px; height: 27px; margin: 0 auto">
            <?php
            foreach ($this->var['months'] as $number => $name) {
                echo '<option value="' . $number++ . '">' . $name . '</option>';
            }
            ?>
        </select>
        <input name="year" type="number" style="width: 100px; margin: 0; font-family: 'Segoe UI'; font-size:16px;" value="<?= $this->var['current_year'] ?>">
    </label>
    <div style="display: flex; padding: 0; flex-direction: column; justify-content: center; align-items: center; height: 100%">
        <?php
        for($t = 0; $t<2; $t++){
            echo '<div style="display: flex; margin-bottom: 40px">';
            for($l = 0; $l <6 ; $l++){
                    echo ' <div style="width: 200px">
                    <table>
            <thead style="text-align: center;">'.$this->var['months'][6*$t+$l].'</thead>
        <tr>
            <td>Пн</td>
            <td>Вт</td>
            <td>Ср</td>
            <td>Чт</td>
            <td>Пт</td>
            <td>Сб</td>
            <td>Вс</td>
        </tr>';
                    for ($i = 0; $i < count($this->var['all_days'][6*$t+$l][2]); $i++) {
                        echo '<tr>';

                        for ($k = 0; $k < 7; $k++) {
                            if ($k > 4) {
                                echo '<td style="text-align: center"><a style="color: red;" href="/calendar/'.$this->var['current_year'].'/'.(6*$t+$l).'/'.$this->var['all_days'][6*$t+$l][2][$i][$k].'">' .$this->var['all_days'][6*$t+$l][2][$i][$k] . '</a></td>';
                            }else if($this->var['all_days'][6*$t+$l][2][$i][$k] == date('j') && ((6*$t+$l)+1) == date('n') && $this->var['current_year'] == date('Y')){
                                echo '<td style="border: 2px solid #2d2d2d; text-align: center"><a href="/calendar/'.$this->var['current_year'].'/'. (6*$t+$l).'/'.$this->var['all_days'][6*$t+$l][2][$i][$k].'">' . $this->var['all_days'][6*$t+$l][2][$i][$k] . '</a></td>';
                            }else {
                                echo '<td style="text-align: center"><a href="/calendar/'.$this->var['current_year'].'/'.(6*$t+$l).'/'.$this->var['all_days'][6*$t+$l][2][$i][$k].'">' . $this->var['all_days'][6*$t+$l][2][$i][$k] . '</a></td>';
                            }
                        }
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '</div>';
                }
            echo '</div>';
        }

        ?>
    </div>
    <script>
        let months = document.getElementsByName('month')["0"];
        let year = document.getElementsByName('year')["0"];
        months.addEventListener('change', function (e) {
            window.location.replace('http://frcomb/calendar/'+year.value+'/'+ months.value);
        });
        year.addEventListener('blur', function (e) {
            window.location.replace('http://frcomb/calendar/'+year.value+'/'+ months.value);
        });
    </script>
</div>


