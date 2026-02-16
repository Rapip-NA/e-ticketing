import '../models/ticket.dart';

class TicketRepository {
  final List<Ticket> _mockTickets = [
    Ticket(
      id: '1',
      title: 'Concert Ticket',
      description: 'Front row seats to the concert',
      price: 100.0,
      date: DateTime.now(),
      imageUrl: 'https://i.pinimg.com/1200x/fa/f1/5b/faf15b6273b9020f3dc9317418d7a96c.jpg',
    ),
    Ticket(
      id: '2',
      title: 'Movie Ticket',
      description: '2D movie ticket',
      price: 10.0,
      date: DateTime.now(),
      imageUrl: 'https://i.pinimg.com/1200x/fa/f1/5b/faf15b6273b9020f3dc9317418d7a96c.jpg',
    ),
  ];

  Future<List<Ticket>> getTickets() async {
    await Future.delayed(const Duration(seconds: 1));
    return _mockTickets;
  }

  Future<Ticket> getTicketById(String id) async {
    await Future.delayed(const Duration(milliseconds: 500));

    try {
      return _mockTickets.firstWhere((ticket) => ticket.id == id);
    } catch (e) {
      throw Exception('Ticket not found');  
    }
  }

  // Future<void> buyTicket(Ticket ticket) async {
  //   await Future.delayed(const Duration(milliseconds: 500));
  //   _mockTickets.removeWhere((ticket) => ticket.id == ticket.id);
  // }
}