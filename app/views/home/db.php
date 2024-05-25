        <div class="container mt-5 p-5 shadow" style="font-size: 15px;">

        <div>
            <span style="font-weight: bold;">Database Test</span>
            <hr class="mb-3" />
            <span>
               Output:
               <br />
               <?php foreach ($data['result'] as $id => $row) { ?>
                <?=$row['text']; ?><br />
               <?php } ?>
            </span>
            <hr class="mb-3" />
        </div>

    </div>