    <html>  
      <head>
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      </head>  
      <body>  
           <div class="container">  
                <br />  
                <br /> 
                <div class="form-group">  
                     <form name="add_name" id="add_name">
						Projekt név(ez lesz a mappa neve)(Ékezet nélkül):<br>
						<input type="text" name="pnev" placeholder = "Projekt neve" /><br><br>
						Tábla neve(Ékezet nélkül)<br>
						<input type="text" name="tnev[1000]" placeholder = "Tábla neve" /><br><br>
						Oszlopok neve,típusa és típus hossza(Ékezetek nélkül):
                          <div class="table-responsive" id = 'table_after'>
                               <table class="table table-bordered" id="dynamic_field">  
                                    <tr>  
                                         <td><input type="text" name="oszlop1000[]" value = 'id' class="form-control name_list" /></td> 
										 <td><select name="tipus1000[]">
										 <option value="INT">INTEGER</option>
											  <option value="VARCHAR">VARCHAR</option>
											  <option value="TEXT">TEXT</option>
											  <option value="TINYINT">BOOLEAN</option>
											  <option value="DATETIME">DATETIME</option>
											</select>
										</td>
										<td><input type="text" name="meret1000[]" value=10></td>
                                         <td><button type="button" name="add" id="add" class="btn btn-success">További oszlop</button></td>   
                                    </tr>  
                               </table>						   
                          </div>
						<input type="button" name="submit" id="submit" class="btn btn-primary" value="Generálás" /> 
				   	    <input type="button" name="addtable" id="addtable" class="btn btn-info" value="Tábla hozzáadása" />							  
                     </form>  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
	  var t=1000;
	  var k=100;
      var i=1;  
	 $('#addtable').click(function(){
		  t++;
		  $('#table_after').after("<div id ='div"+t+"' Tábla neve<br><input type='text' name='tnev["+t+"]' placeholder = 'Tábla neve' /><br><br> Oszlopok neve és értéke:</div><table class='table table-bordered' id='teszt"+t+"'><tr>"+
		  "<td><input type='text'  value = 'id' class='form-control name_list' name ='oszlop"+t+"[]' /></td> "+" <td><select name='tipus"+t+"[]'><option value='INT'>INTEGER</option><option value='VARCHAR'>VARCHAR</option><option value='TEXT'>TEXT</option><option value='TINYINT'>BOOLEAN</option><option value='DATETIME'>DATETIME</option></select></td>"+
		  "<td><input type='text' name='meret"+t+"[]' value = '10'></td><td><button type='button' name='teszt' id='"+t+"' class='btn btn-success btn_teszt'>További oszlop</button></td><td><button type='button' name='tbl_rem' id='"+t+"' class='btn btn-danger btn_tbl_rem'>Tábla törlése</button></td></tr></table>");
	  });
      $(document).on('click', '.btn_teszt', function(){
		k++;
	 var button_id = $(this).attr("id");
		$('#teszt'+button_id).append('<tr id="row'+button_id+k+'"><td><input type="text" name="oszlop'+button_id+'[]" placeholder="Oszlop neve" class="form-control name_list" /></td>'+
		   '<td><select name="tipus'+button_id+'[]"><option value="INT">INTEGER</option><option value="VARCHAR">VARCHAR</option><option value="TEXT">TEXT</option><option value="TINYINT">BOOLEAN</option><option value="DATETIME">DATETIME</option></select></td>'+
		   '<td><input type="text" name="meret'+button_id+'[]" placeholder="Típus mérete"></td><td><button type="button" name="remove" id="'+button_id+k+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      }); 
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="oszlop1000[]" placeholder="Oszlop neve" class="form-control name_list" /></td>'+
		   '<td><select name="tipus1000[]"><option value="INT">INTEGER</option><option value="VARCHAR">VARCHAR</option><option value="TEXT">TEXT</option><option value="TINYINT">BOOLEAN</option><option value="DATETIME">DATETIME</option></select></td>'+
		   '<td><input type="text" name="meret1000[]" placeholder="Típus mérete"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_tbl_rem', function(){  
           var button_id = $(this).attr("id");
		   $('#div'+button_id+'').remove();
           $('#teszt'+button_id+'').remove();		   
      });
	  $(document).on('click', '.btn_remove', function(){ 
           var button_id = $(this).attr("id");
           $('#row'+button_id+'').remove();  
      });
      $('#submit').click(function(){

           $.ajax({  
                url:"generate.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
				if ($.trim(data) !== 'Projekt létrehozása sikeres!')
				{
					alert(data);  
					
				}
				else{
					alert(data);
					location.reload();
				}
							 
                }  
           }); 
      });
 });  
 </script>