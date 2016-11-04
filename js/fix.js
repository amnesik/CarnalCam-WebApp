function getSocket (token) {
    var socket = io.socket.request.bind(io.socket);
    io.socket.request = function (options, cb) {
      options.headers = options.headers || {};
      options.headers['Authorization'] = 'JWT ' + token;
      socket(options, cb);
    };
    return io.socket;
  }