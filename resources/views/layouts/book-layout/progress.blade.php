<?php
$percentage = bookProgress()['percentage'];
// dd( $percentage);
?>
<style>
.progressDiv {
    .progress-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 0;

        h4 {
            font-family: Poppins;
            font-weight: 500;
            font-size: 18px;
            color: #830F35;
        }

        h6 {
            font-weight: 500;
            font-size: 16px;
            color: #414141;
        }
    }

    .progress {
        border-radius: 20px;
        background-color: #C0D9FF;
        height: 12px;
    }

    .progress-bar {
        background-color: #830F35;
        border-radius: 20px;
    }
}
</style>

<div class="progressDiv w-100 ">
    <div class="progress-head">
        <h4>Your Book Progress</h4>
        <h6>{{$percentage}}% Completed</h6>
    </div>
    <div class=" progress ">
        <div class=" progress-bar @if($percentage<1) text-secondary @endif" role="progressbar"
            aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percentage ?>%;">

        </div>
    </div>
</div>