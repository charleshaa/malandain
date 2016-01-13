<?php
    include_once('header.php');

    $user = get_user();
    $pots = get_user_pots();
?>

<body class="uk-height-viewport" >
    <?php if($_GET['success'] == 1){ ?>
    <div class="uk-alert uk-alert-success">
        <p>
            Login successful ! | <a href="/logout">Logout</a>
        </p>
    </div>
    <?php } ?>
    <div class="uk-container uk-container-center" data-uk-observe>
        <div class="uk-grid">
            <div class="uk-width-2-10 uk-panel uk-panel-box">
                <h3 class="uk-panel-title">Your pots</h3>
                <a href="#" id="create-pot-button" class="uk-button uk-button-primary uk-width-1-1 uk-margin-bottom" data-modal="createPot">Create a new pot</a>
                <!-- <ul class="uk-nav uk-nav-side" id="pots-list">

                </ul> -->

                <ul data-uk-nav class="uk-nav uk-nav-side" id="events-list"></ul>
            </div>
            <div class="uk-width-6-10">
                <h2 class="uk-margin-top">Activity</h2>
                <dl class="uk-description-list-line" id="activity-list">

                </dl>
            </div>
            <div class="uk-width-2-10">
                <div id="user-box">
                    <img src="https://gravatar.com/avatar/<?php echo md5($user['email']); ?>" alt="" class="uk-float-left uk-margin-right">
                    <h4><?php echo $user['display_name']; ?></h4>
                    <p>
                        <a href="/logout">Logout</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div id="create-pot" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
            <form class="uk-form" id="create-pot-form">
                <div class="uk-form-row">
                    <label for="event" class="uk-label">Event</label>
                    <div id="event-choice" class="uk-margin-bottom"></div>
                    <p>
                        Or create a new one:
                    </p>
                    <input type="text" placeholder="Name" id="new-event-name">
                    <input type="text" placeholder="Location" id="new-event-loc">
                    <!-- <a href="#" id="create-event-button" class="uk-button">Create</a> -->
                </div>
                <div class="uk-form-row">
                    <label for="title" class="uk-label">Title</label>
                    <input type="text" name="title" id="title" value="" class="uk-width-1-1" placeholder="Title">
                </div>
                <div class="uk-form-row">
                    <label for="currency" class="uk-label">Currency</label>
                    <select name="currency" class="uk-form-select uk-width-1-1" id="currency">
                        <option value="chf">CHF</option>
                        <option value="dollar">$</option>
                        <option value="euro">€</option>
                    </select>
                </div>
                <div class="uk-form-row">
                    <input type="submit" class="uk-button uk-button-primary uk-width-1-1" name="submit" value="Create">
                </div>
            </form>

        </div>
    </div>
    <div id="show-pot" class="uk-modal">
        <div class="uk-modal-dialog">
        </div>
    </div>
    <div id="create-expense" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
            <div class="uk-modal-header">
                <h2>Create an expense</h2>
            </div>
            <form class="uk-form" id="create-expense-form">
                <div class="uk-form-row">
                    <input type="text" placeholder="Description" name="description" id="description" class="uk-width-1-1">
                </div>
                <div class="uk-form-row">
                    <input type="text" placeholder="Amount" name="amount" id="amount" class="uk-width-1-1">
                </div>
                <div class="uk-form-row">
                    <input type="hidden" placeholder="Amount" name="potid" id="expense-pot-id" class="uk-width-1-1">
                </div>
                <div class="uk-form-row">
                    <button type="submit" class="uk-button uk-button-success uk-width-1-1">Create expense</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
