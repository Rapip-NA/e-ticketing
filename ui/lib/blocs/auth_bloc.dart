import 'package:bloc/bloc.dart';
import 'package:meta/meta.dart';
// import 'package:equatable/equatable.dart';
import '../services/auth_service.dart';

part 'auth_event.dart';
part 'auth_state.dart';

class AuthBloc extends Bloc<AuthEvent, AuthState> {
  final AuthService authService;

  AuthBloc({required this.authService}) : super(AuthInitial()) {
    on<LoginRequested>((event, emit) async {
      emit(AuthLoading());
      try {
        final data = await authService.login(event.email, event.password);
        emit(AuthSuccess(message: data['message']));
      } catch (e) {
        emit(AuthFailure(error: e.toString()));
      }
    });

    on<RegisterRequested>((event, emit) async {
      emit(AuthLoading());
      try {
        final data = await authService.register(
          event.name,
          event.email,
          event.password,
        );
        emit(AuthSuccess(message: data['message']));
      } catch (e) {
        emit(AuthFailure(error: e.toString()));
      }
    });

    on<LogoutRequested>((event, emit) async {
      emit(AuthLoading());
      try {
        await authService.logout();
        emit(AuthInitial());
      } catch (e) {
        emit(AuthFailure(error: e.toString()));
      }
    });
  }
}
