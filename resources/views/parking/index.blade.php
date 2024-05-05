<!-- resources/views/cards.blade.php -->
<div class="row" id="cards-container">
    <!-- Cards will be appended here -->
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: '/admin/parkingtae',
            method: 'GET',
            success: function(response) {
                var cardsContainer = $('#cards-container');

                $.each(response, function(index, card) {
                    var cardHtml = `
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">${card.title}</h5>
                                    <p class="card-text">${card.content}</p>
                                </div>
                            </div>
                        </div>
                    `;

                    cardsContainer.append(cardHtml);
                });
            }
        });
    });
</script>
