<table class="pd-table">
    <thead>
        <tr>
            <th style="width:28%;">Bank / Holder</th>
            <th style="width:22%;">Account Number</th>
            <th style="width:10%;" class="center">Status</th>
            <th style="width:15%;" class="right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($paymentDetails as $detail)
            <tr>
                <td>
                    <div class="pd-bank-cell">
                        <div class="bank-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        </div>
                        <div class="bank-info">
                            <span class="bank-name">{{ $detail->bank_name }}</span>
                            <span class="bank-holder">{{ $detail->account_holder }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="pd-account">{{ $detail->account_number }}</span>
                </td>
                <td style="text-align:center;">
                    <span class="pd-status {{ $detail->is_active ? 'active' : 'inactive' }}">
                        <span class="sdot"></span>
                        {{ $detail->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div class="pd-actions">
                        <a href="{{ route('admin.payment-details.edit', $detail) }}" class="btn-action btn-edit">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.payment-details.destroy', $detail) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf @method('DELETE')
                            <button type="button" class="btn-action btn-delete delete-btn">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">
                    <div class="pd-empty">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        </div>
                        <div class="empty-title">No payment details yet</div>
                        <div class="empty-sub">Add your first bank account to receive payments.</div>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@if(method_exists($paymentDetails, 'links'))
    <div class="pd-pagination">
        {{ $paymentDetails->links() }}
    </div>
@endif
