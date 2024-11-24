<div class="modal" id="{{ $id }}" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close-button" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <ul>
                    @foreach ($dates as $date)
                        <li>{{ $date }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="close-button">Close</button>
            </div>
        </div>
    </div>
</div>
