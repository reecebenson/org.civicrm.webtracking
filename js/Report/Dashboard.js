gapi.analytics.ready(function() {

  /**
   * Authorize the user immediately if the user has already granted access.
   * If no access has been created, render an authorize button inside the
   * element with the ID "embed-api-auth-container".
   */
  gapi.analytics.auth.authorize({
    container: 'embed-api-auth-container',
    clientid: CRM.vars.WebTracking.web_tracking_report_id,
  });

  document.getElementById("EmbedAPI").classList.add('Site');
  document.getElementById("EmbedAPI").classList.add('is-authorizing');

  function setAuthorizedState() {
    document.getElementById("EmbedAPI").classList.remove('is-needingAuthorization');
    document.getElementById("EmbedAPI").classList.remove('is-authorizing');
    document.getElementById("EmbedAPI").classList.add('is-authorized');
    gapi.analytics.auth.off('error', setNeedsAuthorizingState)
  }

  function setNeedsAuthorizingState() {
    document.getElementById("EmbedAPI").classList.add('is-needingAuthorization');
  }

  gapi.analytics.auth.on('success', setAuthorizedState);
  gapi.analytics.auth.once('error', setNeedsAuthorizingState);

  /**
   * Create a ViewSelector for the view to be rendered inside of an
   * element with the id "view-selector-container".
   */
  var viewSelector = new gapi.analytics.ViewSelector({
    container: 'view-selector-container'
  });


  // Render the view selector to the page.
  viewSelector.execute();

  var commonConfig = {
    query: {
      metrics: 'ga:pageviews',
      dimensions: 'ga:date'
    },
    chart: {
      type: 'LINE',
      options: {
        width: '100%',
      }
    }
  };

  var dateRange = {
    'start-date': '14daysAgo',
    'end-date': '8daysAgo'
  };

  var dateRangeSelector = new gapi.analytics.ext.DateRangeSelector({
    container: 'date-range-selector-container'
  })
  .set(dateRange)
  .execute();

  //Page Views vs Time
  var pageView = new gapi.analytics.googleCharts.DataChart(commonConfig)
      .set({query: dateRange})
      .set({chart: {container: 'page-view-container', options: {width: '100%'}}});


  dateRangeSelector.on('change', function(data) {
    pageView.set({query: data}).execute();
  });
    

  var countryView = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:country',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
      'max-results': 6,
      sort: '-ga:sessions'
    },
    chart: {
      container: 'country-view-container',
      type: 'PIE',
      options: {
        width: '100%',
        is3D: true
      }
    }
  });

  var sourceTrafficView = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:source',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
      'max-results': 6,
      sort: '-ga:sessions'
    },
    chart: {
      container: 'source-view-container',
      type: 'PIE',
      options: {
        width: '100%',
        is3D: true
      }
    }
  });

  var eventView = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:totalEvents',
      dimensions: 'ga:eventCategory',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
      'max-results': 6,
      sort: '-ga:totalEvents'
    },
    chart: {
      container: 'event-view-container',
      type: 'TABLE',
      options: {
        width: '100%',
        sort: 'disable'
      }
    }
  });

  var transactionView = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:transactionRevenue',
      dimensions: 'ga:affiliation',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
      'max-results': 6,
      sort: '-ga:transactionRevenue'
    },
    chart: {
      container: 'transaction-view-container',
      type: 'TABLE',
      options: {
        width: '100%',
        sort: 'disable'
      }
    }
  });

  var activeUsers = new gapi.analytics.ext.ActiveUsers({
    container: 'active-users-container',
    pollingInterval: 5
  });


  /**
   * Add CSS animation to visually show the when users come and go.
   */
  activeUsers.once('success', function() {
    var element = this.container.firstChild;
    var timeout;

    this.on('change', function(data) {
      var element = this.container.firstChild;
      var animationClass = data.delta > 0 ? 'is-increasing' : 'is-decreasing';
      element.className += (' ' + animationClass);

      clearTimeout(timeout);
      timeout = setTimeout(function() {
        element.className =
            element.className.replace(/ is-(increasing|decreasing)/g, '');
      }, 3000);
    });
  });



  /**
   * Update the dataCharts when the view selecter is changed.
   */
  viewSelector.on('change', function(ids) {
    pageView.set({query: {ids: ids}}).execute();
    countryView.set({query: {ids: ids}}).execute();
    sourceTrafficView.set({query: {ids: ids}}).execute();
    eventView.set({query: {ids: ids}}).execute();
    transactionView.set({query: {ids: ids}}).execute();
    activeUsers.set({ids: ids}).execute();
  });


});