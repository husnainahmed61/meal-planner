<?php
$all_options = get_option( 'covid_options' );
wp_enqueue_style( 'covid' );
$dataAll = get_option('nycreatisAL');
$getFData=new stdClass();$getFData->cases=0;$getFData->deaths=0;$getFData->recovered=0;$getFData->todayCases=0;$getFData->todayDeaths=0;$getFData->active=0;if(is_array($data)){foreach($data as $key=>$value){$getFData->cases+=$value->cases;$getFData->deaths+=$value->deaths;$getFData->recovered+=$value->recovered;$getFData->todayCases+=$value->todayCases;$getFData->todayDeaths+=$value->todayDeaths;$getFData->active+=$value->active;}}else {$getFData->cases+=$data->cases;$getFData->deaths+=$data->deaths;$getFData->recovered+=$data->recovered;$getFData->todayCases+=isset($data->todayCases)?$data->todayCases:0;$getFData->todayDeaths+=isset($data->todayDeaths)?$data->todayDeaths:0;$getFData->active+=isset($data->active)?$data->active:0;}
?>
<div class="ny-covid19-slip js-covid inited <?php echo $all_options['cov_theme'];?> <?php if($all_options['cov_rtl']==!$checked) echo 'rtl_enable'; ?>" style="font-family:<?php echo $all_options['cov_font'];?>">
   <div class="ny-covid19-slip__date js-covid-date"></div>
   <div class="ny-covid19-slip__title"><?php echo esc_html($params['covid_title']); ?></div>
   <div class="ny-covid19-slip__subtitle"><?php echo esc_html__( 'Covid-19', 'covid' );?></div>
   <div class="ny-covid19-slip__tabs__wrap">
      <div class="ny-covid19-slip__tabs"><span onclick="ncrtsTab(event, 'cc')" id="ncrtsCC" class="ny-covid19-slip__tabs__item js-covid-tab tablinks"><?php if (isset($data->countryInfo->flag)) : ?><span class="r-country_flag" style="background:url(<?php echo esc_html($data->countryInfo->flag); ?>) center no-repeat;background-size:cover;"></span>   
      <?php endif; ?><?php echo esc_html(isset($params['country']) ? $params['country'] : ''); ?></span>  <span onclick="ncrtsTab(event, 'ww')" class="ny-covid19-slip__tabs__item js-covid-tab tablinks"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJ4TWlkWU1pZCBtZWV0IiB2aWV3Qm94PSIwIDAgNjQwIDY0MCIgd2lkdGg9IjE4IiBoZWlnaHQ9IjE4Ij48c3R5bGU+PCFbQ0RBVEFbLkJ7ZmlsbC1vcGFjaXR5OjB9LkN7c3Ryb2tlOiMwMDB9LkR7c3Ryb2tlLW9wYWNpdHk6MH0uRXtmaWxsOiMwM2FhNmZ9XV0+PC9zdHlsZT48ZGVmcz48cGF0aCBkPSJNNTE4LjYgMTIxLjQ3bC01NS4xNy0xMS4wNC0zMy4xLTExLjAzLTQ0LjE0IDExLjAzLTMzLjEtMTEuMDMgMjIuMDctNDQuMTRoNDQuMTRsNDMuMjYtMjEuNjNhMzE2LjMxIDMxNi4zMSAwIDAgMSA4OS4xNyA2NS43N2wtMzMuMSAyMi4wN3oiIGlkPSJBIi8+PHBhdGggZD0iTTI5Ny45IDU1LjI2bC0xMS4wNCAzMy4xLTMzLjEgMTEuMDQtMzMuMSA1NS4xOC01NS4xOCAzMy4xLTc3LjI0IDExLjA0djMzLjFsMjIuMDcgMjIuMDd2NDQuMTRMNDQuMSAyNTMuOWwtMTkuMi01Ny43QTMxOS43OCAzMTkuNzggMCAwIDEgMjAwLjM2IDIzLjI2bDMxLjM0IDIwLjk2IDY2LjIgMTEuMDR6IiBpZD0iQiIvPjxwYXRoIGQ9Ik0zMTkuOTggMzY0LjI0bC0xMS4wNCA1NS4xOC00NC4xNCA0NC4xNHYzMy4xbC00NC4xNCAzMy4xdjU1LjE4bC0zMy4xLTExLjA0LTIyLjA4LTU1LjE3VjQwOC40bC01NS4xNy0xMS4wNC0yMi4wNy00NC4xNHYtMzMuMWw1NS4xNy01NS4xNyAyMi4wNyA0NC4xNGg3Ny4yNWwzMy4xIDU1LjE3aDQ0LjE0eiIgaWQ9IkMiLz48cGF0aCBkPSJNNTk5LjE3IDE2My43M2M2MC4yNCAxMDcuNDggNTMuMzggMjQwLTE3LjY2IDM0MC42NmwtMjkuOC0yOS44di00NC4xNGwtNDQuMTQtODguM3YtNDQuMTRsLTMzLjEtMjIuMDdMNDMwLjMzIDI4N2wtNzcuMjUtMzMuMS0xMS4wMy03Ny4yNSAzMy4xLTMzLjFoNjYuMmwyMi4wNyAzMy4xIDY2LjIgMTEuMDQgNjYuMi0yMi4wNyAzLjMtMS44OHoiIGlkPSJEIi8+PHBhdGggZD0iTTM4Ni4yIDExMC40M2w0NC4xNC0xMS4wMyAzMy4xIDExLjAzIDU1LjE3IDExLjA0IDMzLjEtMjIuMDdjMTguNDggMTkuMzQgMzQuNDMgNDAuOTYgNDcuNDUgNjQuMzMtLjIyLjEzLTEuMzIuNzUtMy4zIDEuODhsLTY2LjIgMjIuMDctNjYuMi0xMS4wMy0yMi4wNy0zMy4xaC02Ni4ybC0zMy4xIDMzLjEgMTEuMDQgNzcuMjQgNzcuMjQgMzMuMSA0NC4xNC0xMS4wNCAzMy4xIDIyLjA3djQ0LjE0bDQ0LjE0IDg4LjN2NDQuMTRsMjkuOCAyOS44Yy0xMDEuOSAxNDQuNC0zMDEuNiAxNzguODUtNDQ2IDc2Ljk0QzEyLjkgNDk0Ljc3LTMzLjEyIDMzNC42IDI0LjkgMTk2LjE4bDE5LjIgNTcuNyA2Ni4yIDQ0LjE0LTIyLjA3IDIyLjA3djMzLjFsMjIuMDcgNDQuMTQgNTUuMTcgMTEuMDR2MTEwLjM1bDIyLjA3IDU1LjE3IDMzLjEgMTEuMDR2LTU1LjE4bDQ0LjE0LTMzLjF2LTMzLjFsNDQuMTQtNDQuMTQgMTEuMDQtNTUuMThoLTQ0LjE0bC0zMy4xLTU1LjE3aC03Ny4yNWwtMjIuMDctNDQuMTQtMzMuMSAzMy4xVjI1My45bC0yMi4wNy0yMi4wN3YtMzMuMWw3Ny4yNC0xMS4wNCA1NS4xOC0zMy4xIDMzLjEtNTUuMTcgMzMuMS0xMS4wNCAxMS4wNC0zMy4xLTY2LjItMTEuMDQtMzEuMzQtMjAuOTdjODQuODYtMzQuMTcgMTgwLjMtMzAuNCAyNjIuMiAxMC4zOEw0MTkuMyA1NS4yNmgtNDQuMTVMMzUzLjA4IDk5LjRsMzMuMSAxMS4wM3oiIGlkPSJFIi8+PC9kZWZzPjx1c2UgeGxpbms6aHJlZj0iI0EiIGNsYXNzPSJFIi8+PHVzZSB4bGluazpocmVmPSIjQSIgY2xhc3M9IkIgQyBEIi8+PHVzZSB4bGluazpocmVmPSIjQiIgY2xhc3M9IkUiLz48dXNlIHhsaW5rOmhyZWY9IiNCIiBjbGFzcz0iQiBDIEQiLz48dXNlIHhsaW5rOmhyZWY9IiNDIiBjbGFzcz0iRSIvPjx1c2UgeGxpbms6aHJlZj0iI0MiIGNsYXNzPSJCIEMgRCIvPjx1c2UgeGxpbms6aHJlZj0iI0QiIGNsYXNzPSJFIi8+PHVzZSB4bGluazpocmVmPSIjRCIgY2xhc3M9IkIgQyBEIi8+PHVzZSB4bGluazpocmVmPSIjRSIgZmlsbD0iIzg2ZGFmMSIvPjx1c2UgeGxpbms6aHJlZj0iI0UiIGNsYXNzPSJCIEMgRCIvPjwvc3ZnPg=="><?php echo esc_html($params['world_title']); ?></span></div>
   </div>
   <div class="ny-covid19-slip__parent">
      <div id="cc" class="tabcontent">
      <div class="ny-covid19-slip__content js-covid-content active">
         <div class="ny-covid19-slip__item">
            <div class="ny-covid19-slip__item__diff"><span class="js-covid-ny-con-day">+<?php echo number_format($getFData->todayCases); ?></span> <span class="ny-covid19-slip__item__info">(<?php echo esc_html($params['today_title']); ?>)</span></div>
            <div class="ny-covid19-slip__item__number js-covid-ny-con-total"><?php echo number_format($getFData->cases); ?></div>
            <div class="ny-covid19-slip__item__text"><?php echo esc_html($params['confirmed_title']); ?></div>
         </div>
         <div class="ny-covid19-slip__item__border">0</div>
         <div class="ny-covid19-slip__item ny-covid19-slip__item_2">
            <div class="ny-covid19-slip__item__diff ny-covid19-slip__item__fail"><span class="js-covid-ny-dea-day">+<?php echo number_format($getFData->todayDeaths); ?></span> <span class="ny-covid19-slip__item__info">(<?php echo esc_html($params['today_title']); ?>)</span></div>
            <div class="ny-covid19-slip__item__number js-covid-ny-dea-total"><?php echo number_format($getFData->deaths); ?></div>
            <div class="ny-covid19-slip__item__text"><?php echo esc_html($params['deaths_title']); ?></div>
         </div>
         <div class="ny-covid19-slip__item__border">0</div>		 
         <div class="ny-covid19-slip__item">
            <div class="ny-covid19-slip__item__diff ny-covid19-slip__item__grow"><span class="js-covid-ny-rec-day"><?php echo round(($getFData->recovered)/($getFData->cases)*100, 2); ?>%</span></div>
            <div class="ny-covid19-slip__item__number js-covid-ny-rec-total"><?php echo number_format($getFData->recovered); ?></div>
            <div class="ny-covid19-slip__item__text"><?php echo esc_html($params['recovered_title']); ?></div>
         </div>
         <div class="ny-covid19-slip__item__border">0</div>		 
         <div class="ny-covid19-slip__item ny-covid19-slip__item_2">
            <div class="ny-covid19-slip__item__diff ny-covid19-slip__item__act"><span class="js-covid-ny-act-day"><?php echo round(($getFData->active)/($getFData->cases)*100, 2); ?>%</span></div>
            <div class="ny-covid19-slip__item__number js-covid-ny-act-total"><?php echo number_format($getFData->active); ?></div>
            <div class="ny-covid19-slip__item__text"><?php echo esc_html($params['active_title']); ?></div>
         </div>
      </div>
	 </div>
	 <div id="ww" class="tabcontent">
      <div class="ny-covid19-slip__content js-covid-content">
         <div class="ny-covid19-slip__item">
            <div class="ny-covid19-slip__item__diff"><span class="js-covid-world-con-day">+<?php echo number_format($dataAll->todayCases); ?></span> <span class="ny-covid19-slip__item__info">(<?php echo esc_html($params['today_title']); ?>)</span></div>
            <div class="ny-covid19-slip__item__number js-covid-world-con-total"><?php echo number_format($dataAll->cases); ?></div>
            <div class="ny-covid19-slip__item__text"><?php echo esc_html($params['confirmed_title']); ?></div>
         </div>
         <div class="ny-covid19-slip__item__border">0</div>
         <div class="ny-covid19-slip__item ny-covid19-slip__item_2">
            <div class="ny-covid19-slip__item__diff ny-covid19-slip__item__fail"><span class="js-covid-world-dea-day">+<?php echo number_format($dataAll->todayDeaths); ?></span> <span class="ny-covid19-slip__item__info">(<?php echo esc_html($params['today_title']); ?>)</span></div>
            <div class="ny-covid19-slip__item__number js-covid-world-dea-total"><?php echo number_format($dataAll->deaths); ?></div>
            <div class="ny-covid19-slip__item__text"><?php echo esc_html($params['deaths_title']); ?></div>
         </div>
         <div class="ny-covid19-slip__item__border">0</div>
         <div class="ny-covid19-slip__item">
            <div class="ny-covid19-slip__item__diff ny-covid19-slip__item__grow"><span class="js-covid-world-rec-day"><?php echo round(($dataAll->active)/($dataAll->cases)*100, 2); ?>%</span></div>
            <div class="ny-covid19-slip__item__number js-covid-world-rec-total"><?php echo number_format($dataAll->recovered); ?></div>
            <div class="ny-covid19-slip__item__text"><?php echo esc_html($params['recovered_title']); ?></div>
         </div>
         <div class="ny-covid19-slip__item__border">0</div>
         <div class="ny-covid19-slip__item ny-covid19-slip__item_2">
            <div class="ny-covid19-slip__item__diff ny-covid19-slip__item__act"><span class="js-covid-world-act-day"><?php echo round(($dataAll->active)/($dataAll->cases)*100, 2); ?>%</span></div>
            <div class="ny-covid19-slip__item__number js-covid-world-act-total"><?php echo number_format($dataAll->active); ?></div>
            <div class="ny-covid19-slip__item__text"><?php echo esc_html($params['active_title']); ?></div>
         </div>
      </div>
	 </div>
   </div>
</div>
<script>
	document.getElementById("ncrtsCC").click();
	function ncrtsTab(evt, ncrtsName) {
	  var i, tabcontent, tablinks;
	  tabcontent = document.getElementsByClassName("tabcontent");
	  for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	  }
	  tablinks = document.getElementsByClassName("tablinks");
	  for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	  }
	  document.getElementById(ncrtsName).style.display = "block";
	  evt.currentTarget.className += " active";
	}
</script>