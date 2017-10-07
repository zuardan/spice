<div class="detail">
    <p><label>Periode</label><span><?= $this->detail['date']; ?></span></p>
    <p><label>Start Time</label><span><?= $this->detail['start_time']; ?></span></p>
    <p><label>End Time</label><span><?= $this->detail['end_time']; ?></span></p>
    <p><label>Time Spend</label><span>
            <?
            $first = strtotime($this->detail['start_time']);
            $last = strtotime($this->detail['end_time']);
            echo $timeDiff = ($last - $first) / 60;
            ?></span>
    </p>
    <p><label>Project</label><span><?= $this->detail['project']; ?></span></p>

    <p><label>Location</label><span><?= $this->detail['location']; ?></span></p>

    <p><label>Shift</label><span><?= $this->detail['shift']; ?></span></p>


    <p><label>Transport</label><span><?= $this->detail['transport']; ?></span></p>

    <p><label>Status</label><span><?= $this->detail['status']; ?></span></p>
   
    <p><label>Activity</label><span><?= $this->detail['activity'] ? $this->detail['activity'] : "empty;"; ?></span></p>

</div>