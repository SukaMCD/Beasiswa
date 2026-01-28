<!-- QR Member Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content border-0 shadow rounded-4 text-center overflow-hidden">
            <div class="modal-header border-0 pb-0 justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-0">
                <h5 class="fw-bold mb-3" id="qrTitle">Member QR</h5>

                <div id="qrBox" class="position-relative d-inline-block p-2 bg-white rounded-3 border mb-3">
                    <img id="memberQrImage" src="" alt="QR Code" class="img-fluid" style="width: 200px; height: 200px;">
                    <!-- Logo Overlay -->
                    <div id="qrOverlay" class="position-absolute top-50 start-50 translate-middle bg-white p-1 rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('images/logo_cendana.webp') }}" class="img-fluid rounded-circle" alt="Logo">
                    </div>
                </div>

                <p class="text-secondary small mb-1">Tunjukkan ke kasir untuk scan.</p>
                <div class="badge bg-warning text-dark mb-3" id="qrTimer">04:00</div>
                <div class="d-flex gap-2 mt-2">
                    <a href="{{ route('reward.index') }}" class="btn fw-bold py-2 flex-fill" style="background:#fff; color:#ffd67c; border:2px solid #ffd67c; transition:background 0.2s, color 0.2s; text-decoration: none; display: flex; align-items: center; justify-content: center;"
                        onmouseover="this.style.background='#ffd67c';this.style.color='#222'"
                        onmouseout="this.style.background='#fff';this.style.color='#ffd67c'">
                        Reward
                    </a>
                    <button class="btn fw-bold py-2 flex-fill" id="historyBtn" style="background:#fff; color:#ffd67c; border:2px solid #ffd67c; transition:background 0.2s, color 0.2s;"
                        onmouseover="this.style.background='#ffd67c';this.style.color='#222'"
                        onmouseout="this.style.background='#fff';this.style.color='#ffd67c'">
                        Riwayat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let qrInterval;

    const qrModal = document.getElementById('qrModal');
    // const rewardQrBtn = document.getElementById('rewardQrBtn'); // Removed as it's now a link
    const qrTitle = document.getElementById('qrTitle');
    const qrBox = document.getElementById('qrBox');
    const qrOverlay = document.getElementById('qrOverlay');

    if (qrModal) {
        qrModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const mode = button ? button.getAttribute('data-mode') : 'member';
            refreshQr(mode || 'member');
        });

        qrModal.addEventListener('hidden.bs.modal', function() {
            clearInterval(qrInterval);
        });
    }

    // if (rewardQrBtn) { ... } // Removed logic

    function refreshQr(mode = 'member') {
        const qrImg = document.getElementById('memberQrImage');
        const timerBadge = document.getElementById('qrTimer');

        // Generate QR URL with Current Timestamp to validate 4 mins window
        // Format: JSON {id: UserID, time: Timestamp}
        // Since we are client side, we hit an endpoint to get the configured QR URL from server
        // BUT for MVP/Speed, we can construct the URL here if we trust client timestamp, 
        // BETTER: Hit the Controller endpoint we created `MemberController@qr`

        // Let's us fetch the view content via AJAX? 
        // Simplified: Set src directly to an endpoint that returns the image?
        // Or better: Just reload the image src with a timestamp to bust cache if using static,
        // but we need dynamic data.

        // For this task, let's assume we fetch the data string via an API or just embed ID in blade
        // Using the API.qrserver.com approach from MemberController:

        const userId = "{{ Auth::id() }}";
        const expTime = Date.now() + (4 * 60 * 1000);
        const qrData = JSON.stringify({
            id: userId,
            exp: expTime,
            type: mode
        });
        const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(qrData)}`;

        qrImg.src = qrUrl;
        qrImg.style.opacity = '1';

        if (qrTitle) {
            qrTitle.textContent = mode === 'reward' ? 'Claim Reward' : 'Member QR';
        }

        timerBadge.classList.remove('bg-danger');
        timerBadge.classList.add('bg-warning');

        if (qrBox) {
            if (mode === 'reward') {
                qrBox.style.background = '#fffbe6';
                qrBox.style.borderColor = '#ffd67c';
                qrBox.style.boxShadow = '0 0 0 3px rgba(255, 214, 124, 0.35)';
            } else {
                qrBox.style.background = '#ffffff';
                qrBox.style.borderColor = 'rgba(0,0,0,.125)';
                qrBox.style.boxShadow = 'none';
            }
        }
        if (qrOverlay) {
            if (mode === 'reward') {
                qrOverlay.style.background = '#fff3cd';
            } else {
                qrOverlay.style.background = '#ffffff';
            }
        }

        // Timer Logic
        let timeLeft = 4 * 60; // 4 minutes
        clearInterval(qrInterval);

        updateTimerDisplay(timeLeft, timerBadge);

        qrInterval = setInterval(() => {
            timeLeft--;
            updateTimerDisplay(timeLeft, timerBadge);

            if (timeLeft <= 0) {
                clearInterval(qrInterval);
                timerBadge.textContent = "Expired";
                timerBadge.classList.replace('bg-warning', 'bg-danger');
                qrImg.style.opacity = '0.1';
            }
        }, 1000);
    }

    function updateTimerDisplay(seconds, element) {
        const m = Math.floor(seconds / 60);
        const s = seconds % 60;
        element.textContent = `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    }
</script>
