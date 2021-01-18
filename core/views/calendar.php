<div style="margin:0 auto; margin-top: calc(50vh - 100px); font-family: 'Segoe UI';  width: 200px; height: 200px" >
    <label>

        <select name="month" style="font-family: 'Segoe UI'; font-size:16px; height: 27px">
            <?php
            foreach ($this->var['months'] as $number => $name) {
                echo '<option ' . ($number++ === (int)$this->var['current_month'] - 1 ? 'selected' : '') . ' value="' . $number++ . '">' . $name . '</option>';
            }
            ?>
        </select>
    </label>
    <input name="year" type="number" style="width: 100px; margin: 0; font-family: 'Segoe UI'; font-size:16px;" value="<?= $this->var['current_year'] ?>">
    <table style="width: 200px">
        <tr>
            <td>Пн</td>
            <td>Вт</td>
            <td>Ср</td>
            <td>Чт</td>
            <td>Пт</td>
            <td>Сб</td>
            <td>Вс</td>
        </tr>
        <?php
        for ($i = 0; $i < count($this->var['days']); $i++) {
            echo '<tr>';
            for ($k = 0; $k < 7; $k++) {
                if ($k > 4) {
                    echo '<td style="color: red; text-align: center"><a style="color: red" href="/calendar/'.$this->var['current_year'].'/'.$this->var['current_month'].'/'.$this->var['days'][$i][$k].'">' . $this->var['days'][$i][$k] . '</a></td>';
                }else if($this->var['days'][$i][$k] === (int)date('j') && $this->var['current_month'] === (int)date('n') && $this->var['current_year'] ===  (int)date('Y')){
                    echo '<td style="border: 2px solid #2d2d2d; text-align: center"><a href="/calendar/'.$this->var['current_year'].'/'.$this->var['current_month'].'/'.$this->var['days'][$i][$k].'">' . $this->var['days'][$i][$k] . '</a></td>';
                }else {
                    echo '<td style="text-align: center"><a href="/calendar/'.$this->var['current_year'].'/'.$this->var['current_month'].'/'.$this->var['days'][$i][$k].'">' . $this->var['days'][$i][$k] . '</a></td>';
                }
            }
            echo '</tr>';
        }
        ?>
    </table>
    <script>
        let months = document.getElementsByName('month')["0"];
        let year = document.getElementsByName('year')["0"];
        months.addEventListener('change', function (e) {
            window.location.replace('http://'<?$_SERVER['HTTP_HOST']?>'/calendar/'+year.value+'/'+ months.value);
        });
        year.addEventListener('blur', function (e) {
            z
        });
    </script>
</div>

