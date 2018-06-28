(function($) {
    
    var LoadMorePosts = function(config) {
        this.config = config;
        this.$el = $('#' + this.config.nav_id);
        return this.init();
    };

    LoadMorePosts.prototype.init = function() {
        this.ajax_opts = {
            url: this.config.ajax_url,
            data: {
                action: 'load_more_posts',
                paged: this.config.paged,
                is_home: this.config.is_home,
                is_series_landing: this.config.is_series_landing,
                page_id: this.config.page_id,
                max_num_pages: this.config.max_num_pages,
                query: this.config.query,
                // opt is used by partials/content-series.php to return the same type of post.
                opt: this.config.opt
            },
            type: 'POST',
            dataType: 'html',
            success: this._success.bind(this),
            error: this._error
        };

        console.log(this);

        this.bind_events();

        return this;
    };

    LoadMorePosts.prototype.request = function() {
        // this.$el.addClass('loading');
        $('.loading-image').removeClass('is-hidden');
        // window.loadingShow();
        this.ajax_opts.data.paged += 1;
        this.ajax_opts.data.query = JSON.stringify(this.config.query);
        $.ajax(this.ajax_opts);
        return false;
    };

    LoadMorePosts.prototype.bind_events = function() {
        this.$el.find('a').click(this.request.bind(this));
    };


    LoadMorePosts.prototype._success = function(html) {
        // hide load more button if no more posts to load
        if (this.ajax_opts.data.paged === this.ajax_opts.data.max_num_pages) {
            $('.js-load-more').hide();
        }
        
        if (html.trim() === '') {
            this.$el.html("<span>" + this.config.no_more_posts + "</span>");
        } else {
            var markup = $(html);
            $(html).insertBefore(this.$el.parent());
        }

        $('.loading-image').addClass('is-hidden');
        $(window).trigger('more_loaded');

    };

    LoadMorePosts.prototype._error = function() {
        $('.loading-image').addClass('is-hidden');
        throw "There was an error fetching more posts";
    };

    if (typeof window.LoadMorePosts === 'undefined') {
        window.LoadMorePosts = LoadMorePosts;
    }


    /* 
    #SLIDESHOW / GALLERY 
    //////////////////////////////////////////////////////
    */

    LoadSlideshow = function(config) {
        this.config = config;
        this.$el = $('.' + this.config.slideshow_id);
        return this.init();
    };
    LoadSlideshow.prototype.init = function() {
        this.ajax_opts = {
            url: this.config.ajax_url,
            data: {
                action: 'load_slideshow',
                post_id: this.config.post_id,
                url_referrer: this.config.url_referrer
            },
            type: 'POST',
            dataType: 'html',
            success: this._success.bind(this),
            error: this._error
        };
        this.bind_events();
        return this;
    };

    
    LoadSlideshow.prototype.request = function() {
        $('body').addClass('is-slideshow-loading');

        // window.$loadingOverlay.show();
        // window.loadingOverlayShow();

        $.ajax(this.ajax_opts);
        return false;
    };

    LoadSlideshow.prototype.bind_events = function() {
        // this.$el.click(this.request.bind(this));
        this.$el.on("click", this.request.bind(this));
    };

    LoadSlideshow.prototype._success = function(html) {

        var markup = $(html);
        $(html).insertBefore(this.$el);

        $('body').removeClass('is-slideshow-loading');
        $('html, body').addClass('is-slideshow-open');
        // window.$loadingOverlay.hide();
        // window.loadingOverlayHide();

        $(window).trigger('slideshow_loaded');

    };

    LoadSlideshow.prototype._error = function() {
        $('body').removeClass('is-slideshow-loading');
        // window.$loadingOverlay.hide();
        // window.loadingOverlayHide();

        throw "There was an error opening the slideshow";
    };

    if (typeof window.LoadSlideshow == 'undefined')
        window.LoadSlideshow = LoadSlideshow;



})(jQuery);
