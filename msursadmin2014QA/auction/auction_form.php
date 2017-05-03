<form action="auction/insertnew.php" method="post" class='update1' id='myform'>
		<fieldset>
		<legend>აუქციონის დამატება</legend>
	   <div  class="input_block">
		<div class="well">
			<label for="startdate1">აუქციონის დაწყების თარიღი*</label>
			<div id="datetimepicker1" class="input-append date">
				<input  type="text"  data-format="dd-MM-yyyy hh:mm:ss" id='startdate1' name='startdate1' readonly='readonly' />
				<span class="add-on">
				<i data-time-icon="icon-time" data-date-icon="icon-calendar">	</i>
				</span>
			</div>
			<label for="tilldate1">აუქციონის დასრულების თარიღი*</label>
			<div id="datetimepicker2" class="input-append date">
			<input  type="text" data-format="dd-MM-yyyy hh:mm:ss" id='tilldate1' name='tilldate1' readonly='readonly' />
			<span class="add-on">
			  <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
			</span>
		  </div>
		</div>
		<p>
			<label for="price2">ლოტის ღირებულება*</label>
			<input type="text" name="price" id="price"  /><br /><br />
		</p>
		<p>
			<label for="start_price2">საწყისი ფასი*</label>
			<input type="text" name="start_price" id="start_price"  /><br /><br />
		</p>
		<p>
			<label for="quote2">ბიჯი*</label>
			<input type="text" name="quote" id="quote"  /><br /><br />
		</p>
		<p>
			<label for="reserve2">რეზერვირებული ფასი</label>
			<input type="text" name="reserve" id="reserve"  /><br /><br />
		</p>
		<p>
			<label for="currency">ვალუტა</label>
			<select name='currency'>
			<?php
			$select_currency_units=mysql_query("SELECT * FROM currency_units ORDER BY id");
			while($row_currency_units=mysql_fetch_array($select_currency_units))
			{
				echo "<option value='".$row_currency_units["id"]."'>".$row_currency_units["currency"]."</option>\n";
			}
			?>					
			</select>
		</p>
		</div>
		<div class="input_block">
				<input type="hidden" name="auction" id="auction" value="<?php echo $prod; ?>" />
				<input type='button' id='auctionadd' value='დამატება' />				
	   </div>
	</fieldset>
</form>

<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
	 $('#datetimepicker2').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>
