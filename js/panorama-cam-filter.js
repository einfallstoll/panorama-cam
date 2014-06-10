$(function() {
    var tagChooser = $('#tag-chooser')
    , tagChooserChosen = tagChooser.find('#tag-chooser-chosen')
    , tagChooserTags = tagChooser.find('#tag-chooser-tags')
    , tagChooserResults = tagChooser.find('#tag-chooser-results')
    
    // this will update the search results
    var tagUpdate = function() {
        var data = {}
        
        $(tagChooserChosen.find('button')).each(function() {
            if (typeof data[$(this).data('tag-key')] === 'undefined') {
                data[$(this).data('tag-key')] = []
            }
            
            data[$(this).data('tag-key')].push($(this).data('tag-value'))
        })
        
        $.post('lib/filter.php', data).done(function(data) {
            if (data.length === 0) {
                tagChooserResults.html('<i>Keine Resultate gefunden.</i>')
            } else {
                tagChooserResults.html(data)
            }
        })
    }
    
    // this will append a new filter and disabled the clicked one
    var tagChoose = function() {    
        $(tagChooserChosen.find('i#nofilter')).remove()
        
        if (tagChooserChosen.find('button[data-tag-key=' + $(this).data('tag-key') + '][data-tag-value=' + $(this).data('tag-value') + ']').length === 0) {
            $(this).clone().append(' <i class="glyphicon glyphicon-remove"></i>').appendTo(tagChooserChosen.append(' '))
        }
        
        $(this).addClass('disabled')
        
        tagUpdate()
    }
    
    tagChooserTags.on('click', 'button', tagChoose)
    
    // this will remove the filter and enable the previously disabled
    var tagUnchoose = function() {
        $(tagChooserTags.find('button[data-tag-key=' + $(this).data('tag-key') + '][data-tag-value=' + $(this).data('tag-value') + ']')).removeClass('disabled')
        $(this).remove()
        
        if (tagChooserChosen.find('button').length === 0) {
            tagChooserChosen.append('<i id="nofilter">Keine Filter gesetzt</i>')
        }
        
        tagUpdate()
    }
    
    tagChooserChosen.on('click', 'button', tagUnchoose)
    
    // click all the pre-selected
    tagChooserChosen.find('button').each(function() {
        var chosenTag = tagChooserTags.find('button[data-tag-key=' + $(this).data('tag-key') + '][data-tag-value=' + $(this).data('tag-value') + ']')
        
        if (chosenTag.length > 0) {
            $(chosenTag).trigger('click')
        }
    })
    
    // show image in big
    $('body').on('click', '.thumbnail', function() {
        var container = $('<div id="big-container"></div>')
        $('body').append(container)
        $(this).clone().removeClass('thumbnail').addClass('big').appendTo(container)
    })
    
    // hide image in big
    $('body').on('click', '#big-container', function() {
        $(this).remove()
    })
})
