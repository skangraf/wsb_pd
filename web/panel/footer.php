<?php
// min requirements
include_once '../../vendor/feelcom/wsb/minequirements.php';

?>
<!-- Modal check of reservations -->
<div class="modal fade" id="checkModal" tabindex="-1" role="dialog" aria-labelledby="checkModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Sprawdź termin wizyty</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="checkMsg">
				<form class="checkForm" id="checkForm">

					<div class="form-group">
						<label for="custPhone">Nr kontaktowy</label>
                        <input type="tel" class="form-control" id="custPhone" name="custPhone" placeholder="format: 501-501-501" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" required>
					</div>


					<button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
					<button type="submit" class="btn btn-warning">Sprawdź</button>

				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal display info of reservations -->
<div class="modal fade" id="resModal" tabindex="-1" role="dialog" aria-labelledby="resModal" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Rezerwacje</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="resMsg">
			</div>
		</div>
	</div>
</div>

<!-- jQuery JS -->
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/popper.min.js"></script>

<!-- bootstrap JS -->
<script src="../js/bootstrap.min.js"></script>

<!-- custom JS -->
<script src="./js/custom_adm.js"></script>

<!-- dataTables JS -->
<script src="./js/jquery.dataTables.min.js"></script>
<script src="./js/dataTables.bootstrap4.min.js"></script>
<script src="./js/dataTables.responsive.min.js"></script>
<script src="./js/responsive.bootstrap4.min.js"></script>

</body>

</html>