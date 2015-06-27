
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href='//fonts.googleapis.com/css?family=Open+Sans:600,400,300' rel='stylesheet'>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Embed API Dashboard</title>  
</head>

<div id='EmbedAPI'>

  <aside class="Header-auth" id="header-auth">
    <div class="Header-embedApi" id="embed-api-auth-container"></div>
    <a class="Header-logout" href="https://accounts.google.com/logout">Logout</a>
  </aside> 

  <div class="Content">
    <div class="Dashboard Dashboard--full">
      <header class="Dashboard-header">
        <ul class="FlexGrid">
          <li class="FlexGrid-item">
            <div class="Titles">
              <h1 class="Titles-main" id="view-name">Dashboard</h1>
            </div>
          </li>
          <li class="FlexGrid-item FlexGrid-item--fixed">
            <div id="active-users-container">
              <div class="ActiveUsers">
                "Active Users: "
                <b class="ActiveUsers-value"></b>
              </div>
            </div>
          </li>
        </ul>
        <div class="ViewSelector" id="view-selector-container"></div>
      </header>

      <ul class="FlexGrid FlexGrid--halves">
        <li class="FlexGrid-item">
          <header class="Titles">
            <h1 class="Titles-main">Top Countries</h1>
            <div class="Titles-sub">By sessions</div>
          </header>
          <div id="country-view-container"></div>
        </li>
        <li class="FlexGrid-item">
          <header class="Titles">
            <h1 class="Titles-main">Top Traffic Sources</h1>
            <div class="Titles-sub">By sessions</div>
          </header>
          <div id="source-view-container"></div>
        </li>
        <li class="FlexGrid-item">
          <header class="Titles">
            <h1 class="Titles-main">Top Events</h1>
            <div class="Titles-sub">By total events</div>
          </header>
          <div id="event-view-container"></div>
        </li>
        <li class="FlexGrid-item">
          <header class="Titles">
            <h1 class="Titles-main">Top Affiliations</h1>
            <div class="Titles-sub">By revenue</div>
          </header>
          <div id="transaction-view-container"></div>
        </li>
        <li class="FlexGrid-item">
          <header class="Titles">
            <h1 class="Titles-main">Page Views</h1>
            <div class="Titles-sub">By date</div>
          </header>
          <div id="page-view-container"></div>
          <div id="date-range-selector-container"></div>
        </li>
      </ul>
    </div>
  </div>  
</div>
