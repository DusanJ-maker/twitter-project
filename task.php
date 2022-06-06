$sqlC = "SELECT * FROM fnsInventoryTx WHERE invItem = :invprt ORDER BY invDate DESC";
				
				try{
					$stmtC = $db->prepare($sqlC);
					$stmtC->bindParam(':invprt',$invprt);
					$stmtC->execute();
					$numC = $stmtC->rowCount();
				}catch(PDOException $e){
					$errorC = $e->getMessage();
					reportSystemErrors('getInventoryInfo.phpC',$errorC,$badge);
				}
				
				if($numC>0){
					$a = 0;
					$slocArr[0] = '';
					$wlocArr[0] = '';
					
					while($rowC = $stmtC->fetch(PDO::FETCH_ASSOC)){
						$inventK = htmlentities($rowC['invTkey']);
						$invDate = htmlentities($rowC['invDate']);
						$whseLoc = htmlentities($rowC['invWhouse']);
						$invLctn = htmlentities($rowC['invLoc']);
						$invUser = htmlentities($rowC['invUser']);
						$invType = htmlentities($rowC['invTransType']);
						$invChng = htmlentities($rowC['invQtyChange']);
						$invComm = htmlentities($rowC['invComment']);
						
						if($invType=='Remove'){
						//	$invChng = '-'.$invChng;
						}
						
						
											
						PRINT	'<tr style="text-align: center;">
									<td>'.$invDate.'</td><td>'.$whseLoc.'</td><td>'.$invLctn.'</td><td>'.$nameArr[$invUser].'</td><td>'.$invChng.'</td><td>'.$invType.'</td><td>'.$invComm.'</td></tr>';
						$a++;
					}
				}
				
			PRINT	'</table>
					 </div>
					 <button class="accordion-toggle">Adjust Min/Max</button>
					 <div class="accordion-content">
						<h2>Adjust Inventory Minimums and Maximums</h2>
						<form id="adjustMinMax" name="adjustMinMax" method="post" enctype="multipart/form-data">
						<input type="text" name="token"  value="'.$_SESSION['token'].'" hidden/>
						<input type="text" id="path" name="path" value="adjustMinMax" hidden> 
						<input type="text" id="prtindex" name="prtindex"  value="'.$invkey.'" hidden/>
						<input type="text" id="prtNum" name="prtNum"  value="'.$invprt.'" hidden/>
						<input type="text" id="loccnt" name="loccnt"  value="'.$numB.'" hidden/>
						<table style="width: 75%">
							<tr><th>FNS Location</th><th>Warehouse Location</th><th>Minimum</th><th>Maximum</th></tr>';
							
				for($y=0;$y<$numB;$y++){		
					PRINT	'<tr><td><input type="text" id="invk'.$y.'" name="invk'.$y.'" value="'.$invDkey[$y].'" hidden>
									 <input type="text" id="floc'.$y.'" name="floc'.$y.'" value="'.$invWhse[$y].'" readonly></td>
								 <td><input type="text" id="wloc'.$y.'" name="wloc'.$y.'" value="'.$invLoct[$y].'" readonly></td>
								 <td><input type="text" id="imin'.$y.'" name="imin'.$y.'" value="'.$invMini[$y].'"></td>
								 <td><input type="text" id="imax'.$y.'" name="imax'.$y.'" value="'.$invMaxi[$y].'"></td>
							 </tr>';
				}		
						
			PRINT	'	</table>