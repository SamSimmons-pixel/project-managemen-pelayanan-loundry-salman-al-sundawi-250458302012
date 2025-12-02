<div class="main-wrapper feature-main">
    <div class="container">
        <div class="welcome-section">
            <h1>🎉 Available Promos</h1>
            <p>Use these codes at checkout to get discounts.</p>
        </div>

        <div class="promo-list" style="display: flex; flex-direction: column; gap: 2rem; max-width: 100%; margin: 0 auto;">
            @php
                $groupedPromos = $promos->groupBy(function($item) {
                    return $item->branchAdmin ? $item->branchAdmin->name : 'General Promos';
                });
            @endphp

            @forelse($groupedPromos as $branchName => $branchPromos)
                <div class="branch-group">
                    <h3 style="color: var(--primary); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #eee; background: #fff; width: 100%; padding: 1rem; text-align: left; background-color: #fff; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        Branch: {{ $branchName }}
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @foreach($branchPromos as $promo)
                            <div class="promo-item" style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.5rem; display: flex; align-items: left; justify-content: space-between; gap: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <div class="promo-info" style="flex: 1;">
                                    <h3 style="color: var(--primary); margin-bottom: 0.25rem; font-size: 1.25rem;">{{ $promo->code }}</h3>
                                    <p style="color: var(--text-secondary); margin-bottom: 0.5rem;">Get {{ $promo->discount_percentage }}% off</p>
                                    <p style="font-size: 0.85rem; color: #6b7280;">
                                        Valid until {{ \Carbon\Carbon::parse($promo->valid_until)->format('d M Y') }}
                                    </p>
                                </div>
                                
                                <div class="promo-action">
                                    <button onclick="copyCode('{{ $promo->code }}')" style="background: var(--primary-light); color: var(--primary); border: none; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 0.5rem;">
                                        <span>{{ $promo->code }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 3rem; color: #6b7280;">
                    <p>No active promotions available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" style="visibility: hidden; min-width: 250px; margin-left: -125px; background-color: #333; color: #fff; text-align: center; border-radius: 8px; padding: 16px; position: fixed; z-index: 1; left: 50%; bottom: 30px; font-size: 17px; opacity: 0; transition: opacity 0.5s, bottom 0.5s;">
        Promo code copied to clipboard!
    </div>

    <script>
        function copyCode(code) {
            if (navigator.clipboard && window.isSecureContext) {
                // Navigator clipboard api method'
                navigator.clipboard.writeText(code).then(function() {
                    showToast(code);
                }, function(err) {
                    console.error('Async: Could not copy text: ', err);
                    fallbackCopyTextToClipboard(code);
                });
            } else {
                // Fallback method
                fallbackCopyTextToClipboard(code);
            }
        }

        function fallbackCopyTextToClipboard(text) {
            var textArea = document.createElement("textarea");
            textArea.value = text;
            
            // Avoid scrolling to bottom
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";

            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                var successful = document.execCommand('copy');
                if (successful) {
                    showToast(text);
                } else {
                    console.error('Fallback: Copying text command was unsuccessful');
                }
            } catch (err) {
                console.error('Fallback: Oops, unable to copy', err);
            }

            document.body.removeChild(textArea);
        }

        function showToast(code) {
            var toast = document.getElementById("toast");
            toast.innerText = "Code " + code + " copied!";
            toast.style.visibility = "visible";
            toast.style.opacity = "1";
            toast.style.bottom = "50px";

            setTimeout(function(){ 
                toast.style.visibility = "hidden";
                toast.style.opacity = "0";
                toast.style.bottom = "30px";
            }, 3000);
        }
    </script>
</div>
