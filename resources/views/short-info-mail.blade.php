<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
     <head>
         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width,
initial-scale=1">

         <title>Lefesfera mailer</title>

         <!-- Fonts -->
         <link
href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
rel="stylesheet">

         <!-- Styles -->
         <style>
             /*! normalize.css v8.0.1 | MIT License |
github.com/necolas/normalize.css
*/html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe
UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color
Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color
Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0
solid
#e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0
1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0
rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media
(min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media
(min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media
(min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media
(prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
         </style>

         <style>
             body {
                 font-family: 'Nunito', sans-serif;
             }
         </style>
     </head>
     <body class="antialiased" >
         <div style="background-color: #f9f9f9; padding: 20px;">

             <div  style="max-width: 600px; margin: 0 auto; margin-top: 30px; ">
                 <div class="flex justify-center pt-2 sm:justify-start sm:pt-0">
                     
                 </div>

                 <div style="text-align: center; width: 100%; margin-top: 20px;">
                     <p style="text-align: center; width: 100%">
                         <svg width="113" height="26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.68 17.078V19H.98v-1.922l1.922-.598V2.992L.98 2.512V.59L6.523.402V16.48l2.157.598Zm4.699-3.762c.062.961.351 1.711.867 2.25.524.532 1.203.797 2.04.797.593 0 1.187-.082 1.78-.246a11.894 11.894 0 0 0 1.489-.515c.398-.18.652-.305.761-.375l1.032 1.992c0 .031-.282.23-.844.597-.555.36-1.238.688-2.05.985a7.57 7.57 0 0 1-2.579.433c-2.031 0-3.578-.562-4.64-1.687-1.063-1.125-1.594-2.719-1.594-4.781 0-1.391.254-2.61.761-3.657.516-1.054 1.254-1.867 2.215-2.437.961-.578 2.102-.867 3.422-.867 1.758 0 3.105.504 4.043 1.511.938 1.008 1.406 2.383 1.406 4.125 0 .383-.02.754-.058 1.114-.04.36-.067.586-.082.68l-7.97.081Zm2.426-4.64c-.657 0-1.192.222-1.606.668-.414.437-.672 1.015-.773 1.734h4.347c0-.719-.16-1.297-.48-1.734-.32-.446-.816-.668-1.488-.668Zm7.5 12.96c0-.609.187-1.128.562-1.558a4.35 4.35 0 0 1 1.254-1.008c.469-.242.703-.343.703-.304 0 .03-.133-.004-.398-.106a2.074 2.074 0 0 1-.727-.515c-.21-.243-.316-.567-.316-.973 0-.492.418-1.395 1.254-2.707-.461-.305-.887-.754-1.278-1.348-.382-.594-.574-1.394-.574-2.402 0-1.586.531-2.8 1.594-3.645 1.062-.843 2.45-1.265 4.16-1.265 1.07 0 2.016.191 2.836.574l4.125-.094v1.91l-1.969.34c.016.063.086.262.211.598.133.336.2.77.2 1.3 0 1.665-.52 2.903-1.56 3.715-1.038.805-2.437 1.207-4.194 1.207a4.97 4.97 0 0 1-.81-.058 3.501 3.501 0 0 0-.421-.07l-.094 1.617h3.551c1.54 0 2.723.32 3.55.96.837.641 1.255 1.56 1.255 2.755 0 1.375-.567 2.476-1.7 3.304-1.124.836-2.8 1.254-5.027 1.254-2.015 0-3.55-.265-4.605-.797-1.055-.523-1.582-1.418-1.582-2.683Zm6.117-13.359c-.703 0-1.219.188-1.547.563-.328.375-.492.945-.492 1.71 0 .75.156 1.34.469 1.77.312.422.796.633 1.453.633.734 0 1.258-.191 1.57-.574.313-.383.469-.992.469-1.828 0-.766-.157-1.336-.469-1.711-.313-.375-.797-.563-1.453-.563Zm-1.488 11.204a5.826 5.826 0 0 0-.375.222c-.18.125-.356.3-.528.527a1.375 1.375 0 0 0-.246.81c0 .577.235.96.703 1.148.477.195 1.242.293 2.297.293 1.086 0 1.867-.13 2.344-.387.484-.258.727-.672.727-1.242 0-.516-.188-.875-.563-1.079-.375-.195-.988-.293-1.84-.293h-2.52Zm13.64-6.165c.063.961.352 1.711.867 2.25.524.532 1.203.797 2.04.797.593 0 1.187-.082 1.78-.246a11.894 11.894 0 0 0 1.489-.515c.398-.18.652-.305.762-.375l1.031 1.992c0 .031-.281.23-.844.597-.554.36-1.238.688-2.05.985a7.57 7.57 0 0 1-2.579.433c-2.03 0-3.578-.562-4.64-1.687-1.063-1.125-1.594-2.719-1.594-4.781 0-1.391.254-2.61.762-3.657.515-1.054 1.254-1.867 2.215-2.437.96-.578 2.101-.867 3.421-.867 1.758 0 3.106.504 4.043 1.511.938 1.008 1.407 2.383 1.407 4.125 0 .383-.02.754-.059 1.114-.04.36-.066.586-.082.68l-7.969.081ZM44 8.676c-.656 0-1.191.222-1.605.668-.415.437-.672 1.015-.774 1.734h4.348c0-.719-.16-1.297-.48-1.734-.321-.446-.817-.668-1.489-.668Zm9.809 7.687c0 .016.21.059.632.13.422.07.883.105 1.383.105 1.313 0 1.965-.391 1.957-1.172 0-.352-.183-.637-.55-.856-.368-.218-.95-.46-1.747-.726-.851-.29-1.55-.57-2.097-.844a4.24 4.24 0 0 1-1.407-1.16c-.398-.508-.597-1.152-.597-1.934 0-1.406.469-2.441 1.406-3.105.945-.664 2.125-.996 3.54-.996.64 0 1.288.05 1.944.152.664.102 1.22.215 1.664.34.454.117.735.191.844.223l-.093 3.597h-2.04l-.351-1.441c0-.016-.18-.059-.54-.13a5.732 5.732 0 0 0-1.124-.105c-.531 0-.942.106-1.23.317-.282.203-.422.504-.422.902 0 .352.183.633.55.844.367.21.95.434 1.746.668.852.273 1.551.535 2.098.785.555.25 1.027.617 1.418 1.102.398.476.598 1.097.598 1.863 0 1.36-.5 2.418-1.5 3.176s-2.34 1.136-4.02 1.136c-.672 0-1.336-.039-1.992-.117-.656-.078-1.2-.156-1.629-.234-.422-.078-.688-.137-.797-.176v-3.902h2.156l.2 1.558ZM65.352 5.195c0-1.562.445-2.8 1.335-3.715C67.579.566 68.856.11 70.52.11c.766 0 1.465.066 2.098.199.633.125 1.149.27 1.547.433.398.156.598.242.598.258l-.07 3.527h-2.157l-.363-1.675a4.475 4.475 0 0 0-.48-.059 9.954 9.954 0 0 0-.891-.035c-1.235 0-1.852.68-1.852 2.039v1.488h3.13l-.071 2.39h-3.059v7.805l2.403.598V19H63.43v-1.922l1.922-.598V8.676h-2.157v-2.04l2.157-.35v-1.09Zm12.55 8.121c.063.961.352 1.711.867 2.25.524.532 1.204.797 2.04.797.593 0 1.187-.082 1.78-.246a11.894 11.894 0 0 0 1.49-.515c.398-.18.652-.305.76-.375l1.032 1.992c0 .031-.281.23-.844.597-.554.36-1.238.688-2.05.985a7.57 7.57 0 0 1-2.579.433c-2.03 0-3.578-.562-4.64-1.687-1.063-1.125-1.594-2.719-1.594-4.781 0-1.391.254-2.61.762-3.657.515-1.054 1.254-1.867 2.215-2.437.96-.578 2.101-.867 3.421-.867 1.758 0 3.106.504 4.044 1.511.937 1.008 1.406 2.383 1.406 4.125 0 .383-.02.754-.059 1.114-.039.36-.066.586-.082.68l-7.969.081Zm2.426-4.64c-.656 0-1.191.222-1.605.668-.414.437-.672 1.015-.774 1.734h4.348c0-.719-.16-1.297-.48-1.734-.32-.446-.817-.668-1.489-.668Zm12.633-.985c0-.03.187-.214.562-.55.375-.336.809-.641 1.301-.914.5-.282.992-.422 1.477-.422.383 0 .742.03 1.078.093.336.063.598.13.785.2l.363.129-.187 4.617h-2.156l-.364-2.04c-.414 0-.816.102-1.207.305a4.691 4.691 0 0 0-.984.657c-.266.234-.398.359-.398.375v6.34l2.402.597V19H87.71v-1.922l1.922-.598V8.676l-1.922-.598V6.156l5.039-.117.21 1.652Zm14.285 9.75c0 .032-.207.207-.621.528a7.64 7.64 0 0 1-1.488.879 4.332 4.332 0 0 1-1.782.386c-1.171 0-2.089-.324-2.753-.972-.657-.657-.985-1.586-.985-2.79 0-1.374.492-2.378 1.477-3.011.984-.633 2.418-.95 4.301-.95h1.687v-1.323c0-1.172-.617-1.754-1.852-1.747-.367 0-.707.028-1.019.082a5.37 5.37 0 0 0-.75.176c-.18.055-.293.09-.34.106l-.363 1.511h-2.156l-.164-3.55c.14-.047.484-.149 1.031-.305a22.196 22.196 0 0 1 1.98-.445c.774-.141 1.504-.211 2.192-.211 1.234 0 2.214.156 2.941.468a2.994 2.994 0 0 1 1.594 1.5c.336.688.504 1.614.504 2.778v5.93l1.804.433v1.922L107.68 19l-.434-1.559Zm-4.148-2.332c0 .47.121.829.363 1.079.25.242.601.363 1.055.363.382 0 .761-.102 1.136-.305a6.08 6.08 0 0 0 .95-.644c.257-.227.418-.375.48-.446v-1.605h-1.371c-.93 0-1.598.125-2.004.375-.406.25-.609.644-.609 1.183Z" fill="#353535"></path></svg>
                     </p>
                     <h1 style="text-align: center; width: 100%"><?=$title?></h1>
                 </div>

                 <div style="background-color: white; padding: 20px; margin-bottom: 30px;">
                     <div class="grid grid-cols-1 md:grid-cols-2">
                         <div>
                             <div style="margin-top: 20px;">
                                <p><?=$content?></p>
                             </div>
                         </div>

                     </div>
                 </div>

                 <div class="flex justify-center mt-4 sm:items-center sm:justify-between">

                     <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">

                     </div>
                 </div>
             </div>
         </div>
     </body>
</html>

