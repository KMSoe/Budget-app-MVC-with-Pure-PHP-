<!-- Choose Income or Expense modal -->
<div class="modal" id="choose">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="py-3 ps-3">
                <h5 class="modal-title text-black text-center">
                    Choose
                </h5>
            </div>
            <div class="modal-body">
                <a href="<?= htmlspecialchars(URLROOT) ?>budget/add?type=income" class="me-3">
                    <i class="income fas fa-dollar-sign mb-1"></i>
                    <p>Income</p>
                </a>
                <a href="<?= htmlspecialchars(URLROOT) ?>budget/add?type=expense" class="ms-3">
                    <i class="expense fas fa-file-invoice-dollar mb-1"></i>
                    <p>Expense</p>
                </a>
            </div>
            <div class="pt-2 pb-3 text-center">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel</button>
            </div>
        </div>
    </div>
</div>