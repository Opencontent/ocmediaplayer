{def $identifiers = ezini( 'AttributeIdentifiers', 'Identifier', 'ocmediaplayer.ini' )
     $classes = ezini( 'ClassIdentifiers', 'AudioClasses', 'ocmediaplayer.ini' )
     $file = $identifiers['audio_file']
     $cover = $identifiers['cover']
     $captions = $identifiers['captions']}

{if is_array( $node )}
    {def $children = $node}
    {set $node = $children[0]}
{else}
    {def $children = fetch( 'content', 'list', hash('parent_node_id', $node.node_id,
                                                    'class_filter_type', 'include',
                                                    'class_filter_array', $classes,
                                                    'sort_by', $node.sort_array,
                                                    'limit', 10 ) )}
{/if}

{if $children|count()|gt(0)}

{ezscript_require(array( 'ezjsc::jquery', ocmp('flowplayer','js'), ocmp('controls','js'), ocmp('playlist','js') ) )}
{ezcss_require( array( 'controls-audio.css', 'playlist.css' ))}
<script type="text/javascript">
$(document).ready(function(){ldelim}
    flowplayer("playlistplayer-{$node.node_id}", {ocmp('flowplayer','flash')},
    {ldelim}
        clip:
            {ldelim}
            autoPlay:false,
            autoBuffering: true,
            baseUrl: "{ezurl(no,full)}",
            onStart: function(song) {ldelim}
                    if ( typeof song.metaData.TPE1 !== 'undefined' && typeof song.metaData.TIT2 !== 'undefined'  ){ldelim}
                        $('#playlistcontrolsdetail-{$node.node_id}').html('<span class="artist">'+song.metaData.TPE1+'</span> <span class="title">'+song.metaData.TIT2+'</span>');
                        $('#playlistcontrolsdetail-{$node.node_id}').appendTo($('#playlistcontrols-{$node.node_id}'));
                    {rdelim}	
                {rdelim}	
            {rdelim},
        plugins:
            {ldelim}
                controls: null,
                audio: {ldelim}
                    url: {ocmp('audio','flash')},
                    provider: 'audio',
                {rdelim},
            {rdelim}
    {rdelim}).controls("playlistcontrols-{$node.node_id}").playlist( "#playlist-{$node.node_id}", {ldelim}loop:true{rdelim} );
{rdelim})
</script>

<a	class="player no-js-hide"
    href="{concat('content/download/',$children[0].data_map.$file.contentobject_id,'/',$children[0].data_map.$file.content.contentobject_attribute_id,'/',$children[0].data_map.$file.content.original_filename|slugize()|explode('-')|implode('.'))}"
    title="{$children[0].name|wash()}"
    id="playlistplayer-{$node.node_id}">
</a>

<div id="playlistcontrols-{$node.node_id}" class="controls no-js-hide"></div>
<div id="playlistcontrolsdetail-{$node.node_id}" class="player-detail no-js-hide"></div>

<div class="content-view-children audioplaylist playlist" id="playlist-{$node.node_id}">
    {foreach $children as $index => $child}				
        {if $child.data_map.$file.content.mime_type|eq('audio/mpeg')}
            <a href="{concat('content/download/',$child.data_map.$file.contentobject_id,'/',$child.data_map.$file.content.contentobject_attribute_id,'/',$child.data_map.$file.content.original_filename|slugize()|explode('-')|implode('.'))}">{$child.name|wash()}</a>
        {/if}				
    {/foreach}
</div>

{/if}
{undef}